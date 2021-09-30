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
      challengesUnapprovedTheCurrentUser: [],
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

      this.loading()
      await axios.get('php/get-auth-user.php')
      .then(response => {

        if (response.data) {
          this.authUser = response.data
          this.loading()

          if (this.authUser.role !== 'Admin') {
            this.usersFiltered = this.users.filter((user) => user.team_leader_id == this.authUser.id && user.token == null ).sort().sort((a, b) => a.id - b.id)
          } else {
            this.usersFiltered = this.users.filter((user) => user.token == null ).sort().sort((a, b) => a.id - b.id)
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

        this.challengers = response.data
        this.loading()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
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
          "language": {
              "lengthMenu": "Mostrando _MENU_ registros por página",
              "zeroRecords": "No se encontró nada, lo siento",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "No hay registros disponibles",
              "infoFiltered": "(Filtrando de un total de _MAX_ registros)",
              "search":         "Buscar:",
              "paginate": {
                  "first":      "Primero",
                  "last":       "Último",
                  "next":       "Siguiente",
                  "previous":   "Anterior"
              }
          }
        }).buttons().container().appendTo('#tableUsers_wrapper .col-md-6:eq(0)');
      
      });
      
    },

    async getChallengerByUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/get-challenger-by-user.php', formData)
      .then(response => {

        if (response.data) {

          this.challengesOfTheCurrentUser = response.data
          let user = this.users.filter((user) => user.id == id)
          this.showingUser = user[0]
          this.challengesUnapprovedTheCurrentUser = this.challengesOfTheCurrentUser.filter((challenger) => challenger.approved == 0)
          $('#modalChallengersUser').modal('toggle')
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

    async changeUnitsAuthorized(user) {

      var formData = new FormData();
      formData.append('id', user.id)
      formData.append('user_name', user.name)
      formData.append('user_email', user.email)
      formData.append('team_leader_name', this.authUser.name)
      formData.append('team_leader_email', this.authUser.email)
      formData.append('unit', $('#selectAuthorizedUnits').val())

      this.loading()
      await axios.post('php/change-units-authorized-user.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'Se actualizaron las unidades autorizadas para ' + this.showingUser.name
          $('#modalUnitsAuthorized').modal('toggle')
          this.loading()
          this.getUsers()

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

    async MarkAsReadOneComment(id, index, userId) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/mark-read-comment.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'El mensaje se marco como leído.'
          this.commentsUnreadOfTheCurrentUser.splice( index, 1 )
          this.loading()

          if (this.commentsUnreadOfTheCurrentUser.length == 0) {

            // si no quedan mas comentarios que leer, setear en tabla user 
            // que este usuario no tiene comentarios pendientes de lectura
            formData.append('id', userId)   

            this.loading()
            axios.post('php/update-comments-pending-user.php', formData)
            .then(response => {

              app.msg = 'Ese fue el último mensaje de este usuario.'
              $('#btn_pending_comments_user_' + userId).remove()
              this.loading()

            })
            .catch(error => {
              app.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
              this.loading()
            })

          }

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

    async markAsReadAllMessagesFromThisUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/mark-read-all-comments.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'Se marcaron como leídos todos los comentarios de este usuario.'

          $('#btn_pending_comments_user_' + id).remove()
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

    async markAsApprovedAllChallengerFromThisUser(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/mark-approved-all-challenger.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'Se marcaron como aprobados todos los desafíos presentaados por este usuario.'

          $('#btn_pending_challengers_user_' + id).remove()
          $('#modalChallengersUser').modal('toggle')
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

    async markAsApprovedOneChallenge(id, index, userId) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('php/mark-approved-challenge.php', formData)
      .then(response => {

        if (response.data) {

          this.msg = 'El desafío se marcó como aprobado.'
          this.challengesUnapprovedTheCurrentUser.splice( index, 1 )
          this.loading()

          if (this.challengesUnapprovedTheCurrentUser.length == 0) {

            // si no quedan mas desafios que aprobar, setear en tabla user 
            // que este usuario no tiene desafios pendientes de aprobacion
            formData.append('id', userId)   

            this.loading()
            axios.post('php/update-challengers-pending-user.php', formData)
            .then(response => {

              app.msg = 'Ese fue el último desafío pendiente para este usuario.'
              $('#btn_pending_challengers_user_' + userId).remove()
              this.loading()

            })
            .catch(error => {
              app.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
              this.loading()
            })

          }

        } else {
          this.errors.push('Ops.. Intente nuevamente por favor')
          this.loading()
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

    loading() {
      $('#loading').toggleClass('show_spinner');
    }

  },
  computed: {

  }
});
