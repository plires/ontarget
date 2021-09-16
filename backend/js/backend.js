let app = new Vue({

  el: '#app',
  data: function() {
    return {
      msg: '',
      users: [],
      errors: []
    }
  },

  mounted() {
    this.getUsers()
  },

  methods: {

    async getUsers() {

      await axios.get('php/get-users.php')
      .then(response => {
        this.users = response.data
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

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
