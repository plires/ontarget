let app = new Vue({

  el: '#app',
  data: function() {
    return {
      email_login: '',
      password_login: '',
      msg: '',
      errors: []
    }
  },

  mounted() {
  },

  methods: {

    chekFormLogin() {

      if ( this.validateEmail(this.email_login) && this.password_login ) {
        return true
      }

      if (!this.validateEmail(this.email_login)) {
        this.errors.push('El email no es válido.')
      }

      if ( !this.password_login ) {
        this.errors.push('Ingresá la nueva contraseña.')
      }

      return false

    },

    login() {

      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormLogin()

      if (checked) {

        var formData = new FormData();

        formData.append('email', this.email_login)
        formData.append('password', this.password_login)

        axios.post('php/login.php', formData)
        .then(response => {

          if (response.data) {

            console.log(response.data)

            // loguear usuario. Redireccionar al dashboard
            window.location.replace('./backend.php')

          } else {

            this.errors.push('Email o contraseña incorrectas')

          }

        })
        .catch(error => {
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        })

      }

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
