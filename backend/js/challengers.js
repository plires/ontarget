let app = new Vue({

  el: '#app',
  data: function() {
    return {
      authUser: {},
      moment: moment,
      msg: '',
      users: [],
      usersFiltered: [],
      challenges: [],
      challenges_backup: [],
      challenge: {},
      showingUser: {},
      totalUnits: 6,
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
            this.getChallengers()
          } else {
            this.usersFiltered = this.users.filter((user) => user.token == null ).sort().sort((a, b) => a.id - b.id)
            this.getChallengers()
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

     async getChallengers() {

      this.loading()
      await axios.get('php/get-challengers.php')
      .then(response => {

        this.challenges_backup = response.data

        if (this.authUser.role !== 'Admin') {
          this.challenges = this.challenges_backup.filter((challenge) => challenge.team_leader_id == this.authUser.id).sort((a, b) => a.created_at - b.created_at)
        } else {
          this.challenges = this.challenges_backup.sort((a, b) => a.created_at - b.created_at)
        }

        this.loading()        
        this.initTable()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async viewChallengerHistoryByUser (userId) {

      var table = $('#tableChallengers').DataTable();

      if (userId == '0') {
        this.challenges = this.challenges_backup
 
        // re-draw
        table.clear().rows.add( this.challenges ).draw()

      } else {
        this.challenges = this.challenges_backup.filter((comment) => comment.user_id == userId)
        // re-draw
        table.clear().rows.add( this.challenges ).draw()

      }

    },

    initTable() {
        $("#tableChallengers").DataTable(
        {
          data: this.challenges,
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
                    return '<a onClick="app.showChallenge('+ row.id +')" class="transition" href="#" v-cloak>' + data + '</a>'
                }
              },
              { data: 'name_user',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showChallenge('+ row.id +')" class="transition" href="#" v-cloak>' + row.name_user + '</a>'
                }
              },
              { data: 'created_at',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showChallenge('+ row.id +')" class="transition" href="#" v-cloak>' + moment(data).format('DD/MM/YYYY') + '</a>'
                }
              },
              { data: 'created_at',
                render: function ( data, type, row ) {
                    return '<a onClick="app.showChallenge('+ row.id +')" class="transition" href="#" v-cloak>' + moment(data).format('hh:mm') + '</a>'
                }
              },
              
          ],
          "language": 
            {
                "url": "js/data-table-es_es.json"
            }
        }).buttons().container().appendTo('#tableChallengers_wrapper .col-md-6:eq(0)');

    },

    showChallenge(id) {
      let challenge = this.challenges.filter((challenge) => challenge.id == id)
      this.challenge = challenge[0]

      let user = this.users.filter((user) => user.id == challenge[0].user_id)
      this.showingUser = user[0]
      $('#modalOneChallenge').modal('toggle')
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
