let app = new Vue({

  el: '#app',
  data: function() {
    return {
      name: '',
      email: '',
      phone: '',
      password: '',
      cpassword: '',
      loginContent: false,
      registerContent: false,
      newPasswordContent: false,
      msg: '',
      errors: []
    }
  },

  mounted() {
  },

  methods: {

    closePopUpLogin() {
      $('#login').addClass('hidden')
    },

    openPopUpLogin() {
      this.cleanErrors()
      this.cleanMsgs()
      this.loginContent = true
      this.registerContent = false
      this.newPasswordContent = false
      $('#login').addClass('show')
      $('#login').removeClass('hidden')
    },

    openPopUpRegister() {
      this.cleanErrors()
      this.cleanMsgs()
      this.loginContent = false
      this.registerContent = true
      this.newPasswordContent = false
      $('#login').addClass('show')
      $('#login').removeClass('hidden')
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

    cleanInputs() {
      this.name = ''
      this.email = ''
      this.phone = ''
      this.password = ''
      this.cpassword = ''
    },

    chekFormLogin() {

      this.cleanErrors()

      if ( this.validateEmail(this.email) && this.password ) {
        return true
      }

      if (!this.validateEmail(this.email)) {
        this.errors.push('El email no es válido.')
      }

      if ( !this.password ) {
        this.errors.push('Ingresá la nueva contraseña.')
      }

    },

    login() {

      $('#btnLogin').prop('disabled', true)
      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormLogin()
      
      if (checked) {

        const form = document.querySelector('#formLogin')
        var formData = new FormData(form);

        formData.append('email', this.email)
        formData.append('password', this.password)

        axios.post('/../../php/login.php', formData)
        .then(response => {

          if (response.data) {
            // loguear usuario. Redireccionar al dashboard
          } else {
            this.errors.push('Email o contraseña incorrectas')
          }

          $('#btnLogin').prop('disabled', false)

        })
        .catch(error => {
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnLogin').prop('disabled', false)
          
        })

      }

    },

    chekFormRegister() {

      this.cleanErrors()

      if ( this.name && this.validateEmail(this.email) && this.phone && this.password && this.cpassword && this.password == this.cpassword ) {
        return true
      }

      if (!this.name) {
        this.errors.push('Ingresá tu nombre.')
      }

      if (!this.validateEmail(this.email)) {
        this.errors.push('El email no es válido.')
      }

      if (!this.phone) {
        this.errors.push('Ingresá tu teléfono.')
      }

      if ( !this.password || !this.cpassword ) {
        this.errors.push('Ingresá la nueva contraseña y validala.')
      }

      if ( this.password != this.cpassword ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

    },

    register() {

      let checked = this.chekFormRegister()
      
      if (checked) {

        $('#btnRegister').prop('disabled', false)
        this.cleanErrors()
        this.cleanMsgs()

        const form = document.querySelector('#formRegister')
        var formData = new FormData(form);

        formData.append('name', this.name)
        formData.append('email', this.email)
        formData.append('phone', this.phone)
        formData.append('password', this.password)
        formData.append('cpassword', this.cpassword)

        axios.post('/../../php/register.php', formData)
        .then(response => {

          if (response.data == true) {
            this.msg = 'Registro Exitoso, verificá tu casilla y confirmá tu email. No olvides revisar tu bandeja de SPAM ;)'
            this.cleanInputs()
          } else if( response.data.email_duplicado ) {
            this.errors.push(response.data.email_duplicado_msg)
            $('#btnRegister').prop('disabled', false)
          } else {
            this.errors.push('Verificar los datos ingresados')
            $('#btnRegister').prop('disabled', false)
          }

        })
        .catch(error => {
          this.cleanErrors()
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnRegister').prop('disabled', false)
          
        })

      }
      $('#btnRegister').prop('disabled', false)

    },

  },
  computed: {
    
    //

  }
});
