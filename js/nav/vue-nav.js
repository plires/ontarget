let app = new Vue({

  el: '#app',
  data: function() {
    return {
      name: '',
      email: '',
      phone: '',
      password: '',
      password_reset: '',
      cpassword: '',
      cpassword_reset: '',
      accountContent: false,
      loginContent: false,
      registerContent: false,
      newPasswordContent: false,
      user_id: '',
      msg: '',
      authUser: {},
      units: [],
      episodes: [],
      errors: []
    }
  },

  mounted() {
    this.getAuthUser()
    this.getEpisodes()
  },

  methods: {

    closePopUpLogin() {
      $('#login').addClass('hidden')
    },

    getAuthUser(id = false) {

      axios.get('/../../php/check-auth-user.php')
      .then(response => {

        if (response.data) {
          this.authUser = response.data
        } else {
          this.authUser = {}
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getEpisodes() {

      axios.get('/../../php/get-episodes.php')
      .then(response => {

        this.episodes = response.data

        this.units = this.groupByUnits(this.episodes, 'unit_id');

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    groupByUnits(array, key) {

      let group = array.reduce((r, a) => {
       r[a.unit_id] = [...r[a.unit_id] || [], a];
       return r;
      }, {});
      
      return group

    },

    resetAllPopUp() {
      this.cleanErrors()
      this.cleanMsgs()
      this.accountContent = false
      this.loginContent = false
      this.registerContent = false
      this.newPasswordContent = false
      $('#login').addClass('show')
      $('#login').removeClass('hidden')
    },

    openPopUpAcount() {
      this.resetAllPopUp()
      this.accountContent = true
    },

    openPopUpLogin() {
      this.resetAllPopUp()
      this.loginContent = true
    },

    openPopUpRegister() {
      this.resetAllPopUp()
      this.registerContent = true
    },

    openPopUpNewPass() {
      this.resetAllPopUp()
      this.newPasswordContent = true
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
            this.authUser = response.data
            window.location.replace('./dashboard.php')

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

      if ( this.name && this.validateEmail(this.email) && this.phone && this.password.length >= 6 && this.cpassword && this.password == this.cpassword ) {
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

      if ( this.password.length < 6 ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
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

    chekFormForgotPassword() {

      this.cleanErrors()

      if ( this.validateEmail( this.email) ) {
        return true
      }

      if (!this.validateEmail(this.email)) {
        this.errors.push('El email no es válido.')
      }

    },

    forgotPassword() {

      let checked = this.chekFormForgotPassword()
      
      if (checked) {

        $('#btnNewPass').prop('disabled', false)
        this.cleanErrors()
        this.cleanMsgs()

        const form = document.querySelector('#formRegister')
        var formData = new FormData(form);

        formData.append('email', this.email)

        axios.post('/../../php/forgot-password.php', formData)
        .then(response => {

          if (response.data == true) {
            this.msg = 'Te enviamos los datos a tu casilla de email. No olvides revisar tu bandeja de SPAM ;)'
            this.cleanInputs()
          } else if( response.data.email_inexistente ) {
            this.errors.push(response.data.email_inexistente_msg)
            $('#btnNewPass').prop('disabled', false)
          } else {
            this.errors.push('Verificar los datos ingresados')
            $('#btnNewPass').prop('disabled', false)
          }

        })
        .catch(error => {

          this.cleanErrors()
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnNewPass').prop('disabled', false)
          
        })

      }
      $('#btnNewPass').prop('disabled', false)

    },

    chekFormResetPass() {

      this.cleanErrors()

      if ( this.password_reset && this.password_reset.length >= 6 && this.password_reset == this.cpassword_reset ) {
        return true
      }

      if ( this.password_reset.length < 6 ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
      }

      if ( this.password_reset != this.cpassword_reset ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

    },

    resetPass() {

      let checked = this.chekFormResetPass()
      
      if (checked) {

        $('#btnNewPAss').prop('disabled', false)
        this.cleanErrors()
        this.cleanMsgs()

        const form = document.querySelector('#newPass')
        var formData = new FormData(form);

        formData.append('password_reset', this.password_reset)
        formData.append('cpassword_reset', this.cpassword_reset)

        axios.post('/../../php/new-pass.php', formData)
        .then(response => {

          if (response.data == true) {
            this.msg = 'Reseteo de contraseña exitosa, Esta página se redireccionara al Home del sitio 5 segundos'
            this.cleanInputs()
            setTimeout(function(){
              window.location.replace('./')
            }, 5000)
          } else {
            this.errors.push('Verificar los datos ingresados. La contraseña debe tener al menos 6 caracteres.')
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
