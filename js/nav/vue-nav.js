let app = new Vue({

  el: '#app',
  data: function() {
    return {
      name: '',
      email: '',
      phone: '',
      city: '',
      password: '',
      password_reset: '',
      cpassword: '',
      cpassword_reset: '',
      totalUnits: 6,
      accountContent: false,
      loginContent: false,
      registerContent: false,
      newPasswordContent: false,
      user_id: '',
      msg: '',
      authUser: {},
      id_user: '',
      name_user: '',
      email_user: '',
      phone_user: '',
      city_user: '',
      modeUserEdit: false,
      password_user: '',
      cPassword_user: '',
      mayor_edad: true,
      terminos_condiciones: true,
      units: {},
      episodes: [],
      unitData: '',
      challenges: [],
      currentChallenge: '',
      currentUnit: '',
      teamLeader: {},
      name_contact: '',
      lastname_contact: '',
      email_contact: '',
      phone_contact: '',
      comments_contact: '',
      suscribe_contact: true,
      errors: []
    }
  },

  mounted() {
    this.getAuthUser()
    this.getEpisodes()
    this.getChallenges()
    this.getCurrentUnit()
  },

  methods: {

    closePopUpLogin() {
      $('#login').addClass('hidden')
    },

    async getAuthUser(id = false) {

      let baja = localStorage.getItem('baja')

      if (baja) {
        this.clearLocalStorage()
        this.msg = 'Cuenta dada de baja satisfactoriamente. Ya no tendras acceso a tu dashboard.'
      }

      this.loading()
      await axios.get('/../../php/check-auth-user.php')
      .then(response => {

        if (response.data) {
          this.authUser = response.data
          this.name_user = this.authUser.name
          this.email_user = this.authUser.email
          this.phone_user = this.authUser.phone
          this.city_user = this.authUser.city
          this.id_user = this.authUser.id
        } else {
          this.authUser = {}
          this.name_user = ''
          this.email_user = ''
          this.phone_user = ''
          this.id_user = ''
        }

        this.loading()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getUnitById(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('/../../php/get-unit.php', formData)
      .then(response => {
        this.unitData = response.data
        this.loading()
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getTeamLeaderById(id) {

      var formData = new FormData();
      formData.append('id', id)

      this.loading()
      await axios.post('/../../php/get-team-leader.php', formData)
      .then(response => {
        this.teamLeader = response.data
        this.loading()
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getEpisodes() {

      this.loading()
      await axios.get('/../../php/get-episodes.php')
      .then(response => {

        this.episodes = response.data
        this.units = this.groupByUnits(this.episodes, 'unit_id');
        this.loading()

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
      })

    },

    async getChallenges() {

      this.loading()
      await axios.get('/../../php/get-challenges.php')
      .then(response => {
        this.challenges = response.data
        this.loading()
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
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
      document.getElementById("commentsToTeamLeader").value=''
    },

    chekFormContact() {

      if ( 
          this.name_contact && 
          this.validateEmail(this.email_contact) && 
          this.phone_contact && 
          this.comments_contact
          ) {
        return true
      }

      if ( !this.name_contact ) {
        this.errors.push('Ingresá tu nombre.')
      }

      if (!this.validateEmail(this.email_contact)) {
        this.errors.push('El email no es válido.')
      }

      if ( !this.phone_contact ) {
        this.errors.push('Ingresá tu teléfono.')
      }

      if ( !this.comments_contact ) {
        this.errors.push('Ingresá tus comentarios.')
      }

      return false

    },

    sendContact() {

      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormContact()

      if (checked) {

        var formData = new FormData();

        formData.append('name', this.name_contact)
        formData.append('lastname', this.lastname_contact)
        formData.append('email', this.email_contact)
        formData.append('phone', this.phone_contact)
        formData.append('newsletter', this.suscribe_contact)
        formData.append('comments', this.comments_contact)

        this.loading()
        axios.post('/../../php/send-contact.php', formData)
        .then(response => {

          if (response.data) {

            this.msg = 'Consulta enviada con éxito. Nos comunicaremos con vos a la brevedad'
            this.loading()

          } else {

            this.errors.push('Nombre, email, teléfono y comentarios son obligatorios')
            this.loading()

          }

        })
        .catch(error => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          this.loading()
          
        })

      }

    },

    chekFormLogin() {

      if ( this.validateEmail(this.email) && this.password ) {
        return true
      }

      if (!this.validateEmail(this.email)) {
        this.errors.push('El email no es válido.')
      }

      if ( !this.password ) {
        this.errors.push('Ingresá la nueva contraseña.')
      }

      return false

    },

    login() {

      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormLogin()

      if (checked) {

        const form = document.querySelector('#formLogin')
        var formData = new FormData(form);

        formData.append('email', this.email)
        formData.append('password', this.password)

        this.loading()
        axios.post('/../../php/login.php', formData)
        .then(response => {

          if (response.data) {

            // loguear usuario. Redireccionar al dashboard
            this.authUser = response.data
            this.name_user = this.authUser.name
            this.email_user = this.authUser.email
            this.phone_user = this.authUser.phone
            this.city_user = this.authUser.city
            this.id_user = this.authUser.id
            this.loading()
            window.location.replace(window.location.origin + '/dashboard.php')

          } else {

            this.errors.push('Email o contraseña incorrectas')
            this.loading()

          }

          $('#btnLogin').prop('disabled', false)

        })
        .catch(error => {
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnLogin').prop('disabled', false)
          this.loading()
          
        })

      }

    },

    chekFormRegister() {

      this.cleanErrors()

      if ( this.name && this.validateEmail(this.email) && this.phone && this.city && this.password.length >= 6 && this.cpassword && this.password == this.cpassword && this.mayor_edad && this.terminos_condiciones ) {
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

      if (!this.city) {
        this.errors.push('Ingresá tu ciudad.')
      }

      if ( this.password.length < 6 ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
      }

      if ( this.password != this.cpassword ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

      if (!this.mayor_edad) {
        this.errors.push('Para registrarte tenés que se mayor de 21 años.')
      }

      if (!this.terminos_condiciones) {
        this.errors.push('Para registrarte tenés que aceptar términos y condiciones.')
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
        formData.append('city', this.city)
        formData.append('password', this.password)
        formData.append('cpassword', this.cpassword)

        this.loading()
        axios.post('/../../php/register.php', formData)
        .then(response => {

          if (response.data == true) {

            this.msg = 'Registro Exitoso, verificá tu casilla y confirmá tu email. No olvides revisar tu bandeja de SPAM ;)'
            this.cleanInputs()
            this.loading()

          } else if( response.data.email_duplicado ) {

            this.errors.push(response.data.email_duplicado_msg)
            $('#btnRegister').prop('disabled', false)
            this.loading()

          } else {

            this.errors.push('Verificar los datos ingresados')
            $('#btnRegister').prop('disabled', false)
            this.loading()

          }

        })
        .catch(error => {

          this.cleanErrors()
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnRegister').prop('disabled', false)
          this.loading()
          
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

        this.loading()
        axios.post('/../../php/forgot-password.php', formData)
        .then(response => {

          if (response.data == true) {

            this.msg = 'Te enviamos los datos a tu casilla de email. No olvides revisar tu bandeja de SPAM ;)'
            this.cleanInputs()
            this.loading()

          } else if( response.data.email_inexistente ) {

            this.errors.push(response.data.email_inexistente_msg)
            $('#btnNewPass').prop('disabled', false)
            this.loading()

          } else {

            this.errors.push('Verificar los datos ingresados')
            $('#btnNewPass').prop('disabled', false)
            this.loading()

          }

        })
        .catch(error => {

          this.cleanErrors()
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnNewPass').prop('disabled', false)
          this.loading()
          
        })

      }
      $('#btnNewPass').prop('disabled', false)

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

        $('#btnNewPAss').prop('disabled', false)
        this.cleanErrors()
        this.cleanMsgs()

        const form = document.querySelector('#newPass')
        var formData = new FormData(form);

        formData.append('password_reset', this.password_reset)
        formData.append('cpassword_reset', this.cpassword_reset)

        this.loading()
        axios.post('/../../php/new-pass.php', formData)
        .then(response => {

          if (response.data == true) {

            this.msg = 'Reseteo de contraseña exitosa, Esta página se redireccionara al Home del sitio 5 segundos'
            this.cleanInputs()
            this.loading()
            setTimeout(function(){
              window.location.replace('./')
            }, 5000)

          } else {

            this.errors.push('Verificar los datos ingresados. La contraseña debe tener al menos 6 caracteres.')
            $('#btnRegister').prop('disabled', false)
            this.loading()

          }

        })
        .catch(error => {

          this.cleanErrors()
          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          $('#btnRegister').prop('disabled', false)
          this.loading()
          
        })

      }
      $('#btnRegister').prop('disabled', false)

    },

    getCurrentUnit() {
      let unit = localStorage.getItem('unit')
      
      if (unit) {
        this.currentUnit = unit
        this.unitData = this.getUnitById(unit)
      } else {
        this.currentUnit = 1
      }

    },

    setCurrentUnit(unit) {
      var unitStorage = localStorage.setItem('unit', unit)
    },

    clearLocalStorage() {
      localStorage.clear()
    },

    openModalChallenge(unit, episode, modal) {

      $('#' + modal).modal('toggle')

      let challenge = this.challenges.filter((challenge) => challenge.unit_id == unit && challenge.episode_id == episode)
      this.currentChallenge = challenge[0]
      this.getTeamLeaderById(this.authUser.team_leader_id)

    },

    openModalUploadChallenge() {

      $('#modalChallenge').modal('toggle')
      $('#modalUpload').modal('toggle')
      document.getElementById("comments").value=''

    },

    openModalZoomRequest() {

      $('#modalChallengeZoom').modal('toggle')
      $('#modalZoomRequest').modal('toggle')
      document.getElementById("commentsRequestZoom").value=
      `Hola ${this.teamLeader.name}, soy ${this.authUser.name} y necesito agendar un zoom con vos. Mis horarios y días disponibles son los siguientes:`
    },

    chekFormUploadChallenger() {

      var files = document.getElementById("challengerFile").files;
      var invalidFiles = []
      var invalidFilesSize = []

      for (var i = 0; i < files.length; i++) {

        if (
          files[i].type == 'application/msword' || 
          files[i].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 
          files[i].type == 'application/vnd.ms-excel' || 
          files[i].type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || 
          files[i].type == 'application/pdf'
          ) {

          invalidFiles.push(true)

        } else {

          invalidFiles.push(false)

        }

        if ( files[i].size < 2097152 ) {
          invalidFilesSize.push(true)
        } else {
          invalidFilesSize.push(false)
        }
        
      }

      if ( !invalidFiles.includes(false) && !invalidFilesSize.includes(false) && invalidFiles.length !== 0 ) {
        return true
      } else {
        this.errors.push('Los formatos válidos para subir los desafios son: PDF, XLS, XLSX, DOC y DOCX. Peso Máx: 2mb')
        return false
      }

    },

    uploadChallenger() {

      this.cleanErrors()
      this.cleanMsgs()
      
      let checked = this.chekFormUploadChallenger()

      if (checked) {

        const form = document.querySelector('#formUpload')
        var formData = new FormData(form);

        var files = document.getElementById("challengerFile").files;
        var comments = document.getElementById("comments");

        for( var i = 0; i < files.length; i++ ){
          let file = files[i];
          formData.append('files[' + i + ']', file);
        }

        if (comments.value != '') {
          formData.append('comments', comments.value)
        }

        formData.append('unit', this.currentChallenge.unit_id)
        formData.append('episode', this.currentChallenge.episode_id)
        formData.append('user', this.authUser.id)
        formData.append('user_name', this.authUser.name)
        formData.append('user_email', this.authUser.email)
        formData.append('team_leader', this.authUser.team_leader_id)
        formData.append('team_leader_name', this.teamLeader.name)
        formData.append('team_leader_email', this.teamLeader.email)

        // Limpiar el input file para que este disponible y reseteado en la proxima
        document.getElementById("challengerFile").value=[]
        
        this.loading()
        axios.post('/../../php/upload-challenger.php', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {

          if (response.data === 'Challenger Cargado') {

            this.errors.push('Este desafio ya fue entregado y calificado. No se puede enviar nuevamente. Si tenes alguna duda o consulta por favor comunicate con tu team leader.')
            $('#modalUpload').modal('toggle')
            this.loading()
            return false

          }

          if (response.data) {

            this.msg = 'El desafio se entregó / actualizó correctamente. Tendras novedades de tu team leader en breve.'
            $('#modalUpload').modal('toggle')
            this.loading()

          } else {

            this.errors.push('Los formatos válidos para subir los desafios son: PDF, XLS, XLSX, DOC y DOCX. Peso Max: 2mb.')
            this.loading()

          }

        })
        .catch(errors => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          this.loading()
          
        })

      }

    },

    chekFormSendRequestZoom() {

      var requestZoom = document.getElementById("commentsRequestZoom").value;

      if ( requestZoom ) {
        return true
      } else {
        this.errors.push('Debes completar el campo de texto.')
        return false
      }

    },

    sendRequestZoom() {

      this.cleanErrors()
      this.cleanMsgs()
      
      let checked = this.chekFormSendRequestZoom()

      if (checked) {

        var formData = new FormData();
        var commentsRequestZoom = document.getElementById("commentsRequestZoom");

        formData.append('comments_request_zoom', commentsRequestZoom.value)
        
        formData.append('unit', this.currentChallenge.unit_id)
        formData.append('episode', this.currentChallenge.episode_id)
        formData.append('user', this.authUser.id)
        formData.append('user_name', this.authUser.name)
        formData.append('user_email', this.authUser.email)
        formData.append('team_leader', this.authUser.team_leader_id)
        formData.append('team_leader_name', this.teamLeader.name)
        formData.append('team_leader_email', this.teamLeader.email)

        // Limpiar el input file para que este disponible y reseteado en la proxima
        commentsRequestZoom.value = ''
        
        this.loading()
        axios.post('/../../php/send-comments-request-zoom.php', formData)
        .then(response => {

          if (response.data === 'Zoom Cargado') {

            this.errors.push(`Aparentemente ${this.teamLeader.name} ya tiene una reunión agendada con vos. Por favor ponete en contacto con tu Team Leader asignado`)
            $('#modalZoomRequest').modal('toggle')
            this.loading()
            return false

          }

          if (response.data) {

            this.msg = `La solicitud fue enviada a ${this.teamLeader.name} correctamente. Pronto tendrás respuesta.`
            $('#modalZoomRequest').modal('toggle')
            this.loading()

          } else {

            this.errors.push('El campo de comentarios no puede estar vacio. Enviá tus días y horarios disponibles')
            this.loading()

          }

        })
        .catch(errors => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          this.loading()
          
        })

      }

    },

    openModalPerfilUsuario() {

      $('#modalPerfilUsuario').modal('toggle')
      this.resetAllPopUp()
      this.closePopUpLogin()

    },

    openModalSolicitudBaja() {

      $('#modalSolicitudBaja').modal('toggle')
      this.resetAllPopUp()
      this.closePopUpLogin()

    },

    chekFormUserEdit() {

      if (!this.modeUserEdit) {

        if ( this.name_user && this.phone_user && this.city_user && this.validateEmail(this.email_user) ) {
          this.password_user = ''
          this.cPassword_user = ''
          return true
        }

      } else {
        if ( 
          this.name_user && 
          this.phone_user && 
          this.city_user && 
          this.validateEmail(this.email_user) && 
          this.password_user && 
          this.cPassword_user && 
          this.password_user.length >= 6 && 
          this.cPassword_user.length >= 6 && 
          this.password_user == this.cPassword_user 
          ) {
          return true
        }
      }

      if ( !this.name_user ) {
        this.errors.push('Ingresá tu nombre.')
      }

      if ( !this.validateEmail(this.email_user) ) {
        this.errors.push('Ingresá un email válido.')
      }

      if ( !this.phone_user ) {
        this.errors.push('Ingresá tu teléfono.')
      }

      if ( !this.city_user ) {
        this.errors.push('Ingresá tu ciudad.')
      }

      if ( this.password_user.length < 6 && this.modeUserEdit ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
      }

      if ( this.password_user != this.cPassword_user && this.modeUserEdit ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

      return false

    },

    sendBaja(user_id) {

      var formData = new FormData();

      formData.append('user_id', user_id)
      formData.append('user_email', this.authUser.email)

      this.loading()
      axios.post('/../../php/baja-user.php', formData)
      .then(response => {

        if (response.data) {

          $('#modalSolicitudBaja').modal('toggle')
          this.loading()
          this.clearLocalStorage()
          axios.get('/../../php/logout.php')
          localStorage.setItem('baja', true)
          window.location.replace(window.location.origin + '/')

        } else {

          this.errors.push('Error inesperado, por favor intentá nuevamente.')
          this.loading()

        }

      })
      .catch(errors => {

        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
        this.loading()
        
      })

    },

    sendUserEdit(user_id) {

      this.cleanErrors()
      this.cleanMsgs()

      let checked = this.chekFormUserEdit()

      if (checked) {

        var formData = new FormData();

        formData.append('mode_user_edit', this.modeUserEdit)
        formData.append('name', this.name_user)
        formData.append('email', this.email_user)
        formData.append('old_email', this.authUser.email)
        formData.append('phone', this.phone_user)
        formData.append('city', this.city_user)
        formData.append('password', this.password_user)
        formData.append('cPassword', this.cPassword_user)
        formData.append('user_id', this.id_user)

        this.loading()
        axios.post('/../../php/set-user.php', formData)
        .then(response => {

          if (response.data) {

            this.msg = 'El usuario actualizó correctamente.'
            $('#modalPerfilUsuario').modal('toggle')
            this.loading()
            this.getAuthUser()

          } else {

            this.errors.push('Todos los campos son obligatorios. Si elegiste resetear la contraseña esta debe ser mayor o igual a 6 caracteres y coincidir con el campo de repetir contraseña')
            this.loading()

          }

        })
        .catch(errors => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          this.loading()
          
        })

      }

    },

    openModalContatcYourTeamLeader() {

      document.getElementById("commentsToTeamLeader").value=''

      this.getTeamLeaderById(this.authUser.team_leader_id)
      $('#modalContactYourTeamLeader').modal('toggle')
      this.resetAllPopUp()
      this.closePopUpLogin()

    }, 

    chekFormCommentToTeamLeader() {
      this.cleanErrors()
      this.cleanMsgs()

      var comment = document.getElementById("commentsToTeamLeader")

      if ( comment.value ) {
        return true
      }

      if ( comment.value == '' ) {
        this.errors.push('Completa el campo de consulta.')
      }

      return false
    },

    sendCommentsToTeamLeader() {

      let checked = this.chekFormCommentToTeamLeader()

      if (checked) {
        var comment = document.getElementById("commentsToTeamLeader")

        var formData = new FormData();
        formData.append('team_leader_id', this.teamLeader.id)
        formData.append('team_leader_name', this.teamLeader.name)
        formData.append('team_leader_email', this.teamLeader.email)
        formData.append('user_id', this.authUser.id)
        formData.append('user_name', this.authUser.name)
        formData.append('user_email', this.authUser.email)
        formData.append('user_phone', this.authUser.phone)
        formData.append('user_city', this.authUser.city)
        formData.append('comment', comment.value)

        this.loading()
        axios.post('/../../php/set-comment-to-team-leader.php', formData)
        .then(response => {

          if (response.data) {

            comment.value = ''
            this.resetAllPopUp()
            this.closePopUpLogin()
            $('#modalContactYourTeamLeader').modal('toggle')
            this.msg = 'El comentario se envió correctamente. '+ this.teamLeader.name + ' se comunicará con vos a la brevedad.'
            this.loading()

          } else {

            this.resetAllPopUp()
            this.closePopUpLogin()
            this.errors.push('Hubo un error. Verifique los datos e intente nuevamente.')
            this.loading()

          }


        })
        .catch(error => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          this.loading()

        })
      }


    }, 

    loading() {
      $('#loading').toggleClass('show_spinner');
    }

  },
  computed: {

    filterEpisodesByUnit: function() {
      return this.episodes.filter((episode) => episode.unit_id == this.currentUnit)
    },

    percentComplete() {
      return Math.round((this.authUser.authorized_units * 100) / this.totalUnits)
    }

  }
});
