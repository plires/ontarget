let app = new Vue({

  el: '#app',
  data: function() {
    return {
      moment: moment,
      msg: '',
      users: [],
      challengers: [],
      showingUser: {},
      totalUnits: 6,
      challengesOfTheCurrentUser: [],
      commentsOfTheCurrentUser: [],
      commentsUnreadOfTheCurrentUser: [],
      errors: []
    }
  },

  mounted() {
    this.getUsers()
    this.getChallengers()
  },

  methods: {

    async getUsers() {

      await axios.get('php/get-users.php')
      .then(response => {
        this.users = response.data.filter((user) => user.team_leader_id == 2 ).sort().sort((a, b) => a.id - b.id)// && user.episode_id == episode)
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

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
          // $('#modalLastComments').modal('toggle')

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
