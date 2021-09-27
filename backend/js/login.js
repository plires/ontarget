let app = new Vue({

  el: '#app',
  data: function() {
    return {
      email_login: '',
      password_login: '',
      email_forgot_password: '',
      user_id: '',
      password_reset: '',
      cpassword_reset: '',
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

    chekFormForgotPassword() {

      if ( this.validateEmail(this.email_forgot_password) ) {
        return true
      }

      if (!this.validateEmail(this.email_login)) {
        this.errors.push('El email no es válido.')
      }

      return false

    },

    forgotPassword() {

      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormForgotPassword()

      if (checked) {

        var formData = new FormData();

        formData.append('email', this.email_forgot_password)

        axios.post('php/forgot-password.php', formData)
        .then(response => {

          // console.log(response.data)

          if (response.data) {

            // Mostrar msg de envio de contraseña
            this.msg = 'Te enviamos email con instrucciones. Verifica SPAM por las dudas.'

          } else if (response.data.email_inexistente) {

            // Mostrar error de envio de contraseña
            this.errors.push(response.data.email_inexistente_msg)

          } else {

            // Mostrar error de envio de contraseña
            this.errors.push('Email incorrecto o inexistente')

          }

        })
        .catch(error => {
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        })

      }

    },

    chekFormResetPass() {

      this.cleanErrors()
      this.cleanMsgs()

      if ( this.password_reset && this.password_reset.length >= 6 && this.password_reset == this.cpassword_reset ) {
        return true
      }

      if ( this.password_reset.length < 6 ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
      }

      if ( this.password_reset != this.cpassword_reset ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

      return false

    },

    resetPass() {

      let checked = this.chekFormResetPass()
      
      if (checked) {

        $('#btnNewPass').prop('disabled', false)
        this.cleanErrors()
        this.cleanMsgs()

        var formData = new FormData();

        formData.append('user_id', this.user_id)
        formData.append('password_reset', this.password_reset)
        formData.append('cpassword_reset', this.cpassword_reset)

        axios.post('php/new-pass.php', formData)
        .then(response => {

          if (response.data) {
            this.msg = 'Reseteo de contraseña exitosa, Esta página se redireccionara al login del backend en 5 segundos'
            this.cleanErrors()
            setTimeout(function(){
              window.location.replace('./')
            }, 5000)
          } else {
            this.errors.push('Verificar los datos ingresados. La contraseña debe tener al menos 6 caracteres.')
          }

        })
        .catch(error => {
          this.cleanErrors()
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
