let app = new Vue({

  el: '#app',
  data: function() {
    return {
      authUser: {},
      moment: moment,
      msg: '',
      users: [],
      usersFiltered: [],
      comments: [],
      comments_backup: [],
      showingUser: {},
      totalUnits: 6,
      commentsOfTheCurrentUser: [],
      commentsUnreadOfTheCurrentUser: [],
      comment: '',
      initializedTable: false,
      errors: []
    }
  },

  mounted() {
    this.getUsers()
  },

  methods: {

    async getAuthUser(id = false) {

      this.loading()
      await axios.get('php/get-auth-user.php')
      .then(response => {

        if (response.data) {
          this.authUser = response.data

          if (this.authUser.role !== 'Admin') {
            this.usersFiltered = this.users.filter((user) => user.team_leader_id == this.authUser.id && user.token == null ).sort().sort((a, b) => a.id - b.id)
            this.getComments()            
          } else {
            this.usersFiltered = this.users.filter((user) => user.token == null ).sort().sort((a, b) => a.id - b.id)
            this.getComments()
          }

          this.loading()

        } else {

          this.errors.push('Hubo un problema al loeguear al usuario. Refrescá la página o logueate nuevamente.')
          this.authUser = {}
          this.loading()

        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getUsers() {

      this.loading()
      await axios.get('php/get-users.php')
      .then(response => {

        this.users = response.data
        this.getAuthUser()
        this.loading()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getComments() {

      this.loading()
      await axios.get('php/get-comments.php')
      .then(response => {
        this.comments_backup = response.data

        if (this.authUser.role !== 'Admin') {
          this.comments = this.comments_backup.filter((comment) => comment.team_leader_id == this.authUser.id).sort((a, b) => a.created_at - b.created_at)
        } else {
          this.comments = this.comments_backup.sort((a, b) => a.created_at - b.created_at)          
        }
        
        this.loading()
        this.initTable()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async viewCommentHistoryByUser (userId) {

      var table = $('#tableComments').DataTable();

      if (userId == '0') {
        this.comments = this.comments_backup
 
        // re-draw
        table.clear().rows.add( this.comments ).draw()

      } else {
        this.comments = this.comments_backup.filter((comment) => comment.user_id == userId)
        // re-draw
        table.clear().rows.add( this.comments ).draw()

      }

    },

    initTable() {
        $("#tableComments").DataTable(
        {
          data: this.comments,
          "responsive": true, 
          "lengthChange": false, 
          "autoWidth": false,
          "stateSave": true,
          "ordering": true,
          "order": [[0, 'desc']],
          "searching": true,
          "columns": [
              { data: 'id',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showComment('+ row.id +')" class="transition" href="#" v-cloak>' + data + '</a>'
                }
              },
              { data: 'name_user',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showComment('+ row.id +')" class="transition" href="#" v-cloak>' + row.name_user + '</a>'
                }
              },
              { data: 'created_at',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showComment('+ row.id +')" class="transition" href="#" v-cloak>' + moment(data).format('DD/MM/YYYY') + '</a>'
                }
              },
              { data: 'created_at',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showComment('+ row.id +')" class="transition" href="#" v-cloak>' + moment(data).format('hh:mm') + '</a>'
                }
              },
          ],
          "language": 
            {
                "url": "js/data-table-es_es.json"
            }
        }).buttons().container().appendTo('#tableComments_wrapper .col-md-6:eq(0)');

        // $('#example2').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": true,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false,
        //   "responsive": true,
        // });
      
      
    },

    showComment(id) {
      let comment = this.comments.filter((comment) => comment.id == id)
      this.comment = comment[0]

      let user = this.users.filter((user) => user.id == comment[0].user_id)
      this.showingUser = user[0]
      $('#modalOneComment').modal('toggle')
    },

    async getCommentsByUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/get-comments-by-user.php', formData)
      .then(response => {

        if (response.data) {

          this.commentsOfTheCurrentUser = response.data
          this.commentsUnreadOfTheCurrentUser = this.commentsOfTheCurrentUser.filter((comment) => comment.unread == 1)
          $('#modalLastComments').modal('toggle')
          this.loading()

        } else {

          this.errors.push('Ops.. Intente nuevamente por favor')
          this.loading()

        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    cleanErrors() {
      this.errors = []
    },

    cleanMsgs() {
      this.msg = ''
    },

    loading() {
      $('#loading').toggleClass('show_spinner');
    }

  },
  computed: {

  }
});
