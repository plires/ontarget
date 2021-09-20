let app = new Vue({

  el: '#app',
  data: function() {
    return {
      authUser: {},
      moment: moment,
      msg: '',
      users: [],
      usersFiltered: [],
      challengers: [],
      showingUser: {},
      totalUnits: 6,
      challengesOfTheCurrentUser: [],
      commentsOfTheCurrentUser: [],
      commentsUnreadOfTheCurrentUser: [],
      initializedTable: false,
      errors: []
    }
  },

  mounted() {
    this.getUsers()
    this.getChallengers()
  },

  methods: {

    async getAuthUser(id = false) {
      await axios.get('php/get-auth-user.php')
      .then(response => {
        if (response.data) {
          this.authUser = response.data

          if (this.authUser.role !== 'Admin') {
            this.usersFiltered = this.users.filter((user) => user.team_leader_id == this.authUser.id ).sort().sort((a, b) => a.id - b.id)
          } else {
            this.usersFiltered = this.users
          }

          if (!this.initializedTable) {
            this.initTable()
            this.initializedTable = true
          }

        } else {
          this.errors.push('Hubo un problema al loeguear al usuario. Refrescá la página o logueate nuevamente.')
          this.authUser = {}
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getUsers() {

      await axios.get('php/get-users.php')
      .then(response => {
        this.users = response.data
        this.getAuthUser()
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    initTable() {
      $(document).ready(function () { 
        $("#tableUsers").DataTable(
        {
          "responsive": true, 
          "lengthChange": false, 
          "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
          "stateSave": true,
          "ordering": true,
          "order": [[0, 'desc']],
          // "language": 
          //   {
          //       "url": "js/data-table-es_es.json"
          //   }
        }).buttons().container().appendTo('#tableUsers_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
      
    },

    async getChallengers() {

      await axios.get('php/get-challengers.php')
      .then(response => {
        this.challengers = response.data
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getChallengerByUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('php/get-challenger-by-user.php', formData)
      .then(response => {

        if (response.data) {

          this.challengesOfTheCurrentUser = response.data
          let user = this.users.filter((user) => user.id == id)
          this.showingUser = user[0]
          $('#modalChallengersUser').modal('toggle')

        } else {
          this.errors.push('Ops.. Intente nuevamente por favor')
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async changeUnitsAuthorized(id) {

      var formData = new FormData();
      formData.append('id', id)
      formData.append('unit', $('#selectAuthorizedUnits').val())

      await axios.post('php/change-units-authorized-user.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'Se actualizaron las unidades autorizadas para ' + this.showingUser.name
          $('#modalUnitsAuthorized').modal('toggle')
          this.getUsers()

        } else {

          this.errors.push('Ops.. Intente nuevamente por favor')

        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getCommentsByUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('php/get-comments-by-user.php', formData)
      .then(response => {

        if (response.data) {

          this.commentsOfTheCurrentUser = response.data
          this.commentsUnreadOfTheCurrentUser = this.commentsOfTheCurrentUser.filter((comment) => comment.unread == 1)
          $('#modalLastComments').modal('toggle')

        } else {
          this.errors.push('Ops.. Intente nuevamente por favor')
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async MarkAsReadOneComment(id, index) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('php/mark-read-comment.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'El mensaje se marco como leído.'
          this.commentsUnreadOfTheCurrentUser.splice( index, 1 )

        } else {
          this.errors.push('Ops.. Intente nuevamente por favor')
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async markAsReadAllMessagesFromThisUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('php/mark-read-all-comments.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'Se marcaron como leídos todos los comentarios de este usuario.'

          $('#btn_pending_comments_user_' + id).remove()
          $('#modalLastComments').modal('toggle')

        } else {
          this.errors.push('Ops.. Intente nuevamente por favor')
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    viewUserData(user_id) {
      this.showingUser = {}
      $('#modalDataUser').modal('toggle')
      let showingUser = this.users.filter((user) => user.id == user_id)
      this.showingUser = showingUser[0]
    },

    openModalUnitsAuthorized(user_id) {
      $("#selectAuthorizedUnits").val() // reset select
      
      this.showingUser = {}
      let showingUser = this.users.filter((user) => user.id == user_id)
      this.showingUser = showingUser[0]

      $("#selectAuthorizedUnits option[value="+ this.showingUser.authorized_units +"]").attr("selected",true) // add att select
      $('#selectAuthorizedUnits').val(this.showingUser.authorized_units).trigger('change') // Provocar refresh
      $('#modalUnitsAuthorized').modal('toggle')
      
    },

    validateEmail(email) {
      const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email)
    },

    cleanErrors() {
      this.errors = []
    },

    cleanMsgs() {
      this.msg = ''
    },

  },
  computed: {

  }
});
