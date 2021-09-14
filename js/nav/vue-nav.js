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
      id_user: '',
      name_user: '',
      email_user: '',
      phone_user: '',
      modeUserEdit: false,
      password_user: '',
      cPassword_user: '',
      units: {},
      episodes: [],
      unitData: '',
      challenges: [],
      currentChallenge: '',
      currentUnit: '',
      teamLeader: {},
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

      await axios.get('/../../php/check-auth-user.php')
      .then(response => {

        if (response.data) {
          this.authUser = response.data
          this.name_user = this.authUser.name
          this.email_user = this.authUser.email
          this.phone_user = this.authUser.phone
          this.id_user = this.authUser.id
        } else {
          this.authUser = {}
          this.name_user = ''
          this.email_user = ''
          this.phone_user = ''
          this.id_user = ''
        }

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getUnitById(id) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('/../../php/get-unit.php', formData)
      .then(response => {
        this.unitData = response.data
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getTeamLeaderById(id) {

      var formData = new FormData();
      formData.append('id', id)

      await axios.post('/../../php/get-team-leader.php', formData)
      .then(response => {
        this.teamLeader = response.data
      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getEpisodes() {

      await axios.get('/../../php/get-episodes.php')
      .then(response => {

        this.episodes = response.data

        this.units = this.groupByUnits(this.episodes, 'unit_id');

      })
      .catch(error => {
        this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
      })

    },

    async getChallenges() {

      await axios.get('/../../php/get-challenges.php')
      .then(response => {
        this.challenges = response.data
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
      document.getElementById("commentsToTeamLeader").value=''
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

        axios.post('/../../php/login.php', formData)
        .then(response => {

          if (response.data) {

            // loguear usuario. Redireccionar al dashboard
            this.authUser = response.data
            this.name_user = this.authUser.name
            this.email_user = this.authUser.email
            this.phone_user = this.authUser.phone
            this.id_user = this.authUser.id
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

    openModalChallenge(unit, episode) {

      $('#modalChallenge').modal('toggle')

      let challenge = this.challenges.filter((challenge) => challenge.unit_id == unit && challenge.episode_id == episode)
      this.currentChallenge = challenge[0]

    },

    openModalUploadChallenge() {

      $('#modalChallenge').modal('toggle')
      $('#modalUpload').modal('toggle')

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
        formData.append('team_leader', this.authUser.team_leader_id)

        // Limpiar el input file para que este disponible y reseteado en la proxima
        document.getElementById("challengerFile").value=[]
      
        axios.post('/../../php/upload-challenger.php', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {

          if (response.data === 'Challenger Cargado') {
            this.errors.push('Este desafio ya fue entregado y calificado. No se puede enviar nuevamente. Si tenes alguna duda o consulta por favor comunicate con tu team leader.')
            $('#modalUpload').modal('toggle')
            return false
          }

          if (response.data) {
            this.msg = 'El desafio se entregó / actualizó correctamente. Tendras novedades de tu team leader en breve.'
            $('#modalUpload').modal('toggle')
          } else {
            this.errors.push('Los formatos válidos para subir los desafios son: PDF, XLS, XLSX, DOC y DOCX. Peso Max: 2mb.')
          }

        })
        .catch(errors => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          
        })

      }

    },

    openModalPerfilUsuario() {

      $('#modalPerfilUsuario').modal('toggle')
      this.resetAllPopUp()
      this.closePopUpLogin()

    },

    chekFormUserEdit() {

      if (!this.modeUserEdit) {

        if ( this.name_user && this.phone_user && this.validateEmail(this.email_user) ) {
          this.password_user = ''
          this.cPassword_user = ''
          return true
        }

      } else {
        if ( 
          this.name_user && 
          this.phone_user && 
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

      if ( this.password_user.length < 6 && this.modeUserEdit ) {
        this.errors.push('La contraseña debe tener al menos 6 caracteres.')
      }

      if ( this.password_user != this.cPassword_user && this.modeUserEdit ) {
        this.errors.push('Las contraseñas son diferentes.')
      }

      return false

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
        formData.append('phone', this.phone_user)
        formData.append('password', this.password_user)
        formData.append('cPassword', this.cPassword_user)
        formData.append('user_id', this.id_user)

        axios.post('/../../php/set-user.php', formData)
        .then(response => {

          console.log(response.data)

          if (response.data) {
            this.msg = 'El usuario actualizó correctamente.'
            $('#modalPerfilUsuario').modal('toggle')
          } else {
            this.errors.push('Todos los campos son obligatorios. Si elegiste resetear la contraseña esta debe ser mayor o igual a 6 caracteres y coincidir con el campo de repetir contraseña')
          }

        })
        .catch(errors => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')
          
        })

      }

    },

    openModalContatcYourTeamLeader() {

      this.cleanInputs()

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
        formData.append('user_id', this.authUser.id)
        formData.append('comment', comment.value)

        axios.post('/../../php/set-comment-to-team-leader.php', formData)
        .then(response => {

          if (response.data) {

            comment.value = ''
            this.resetAllPopUp()
            this.closePopUpLogin()
            $('#modalContactYourTeamLeader').modal('toggle')
            this.msg = 'El comentario se envió correctamente. '+ this.teamLeader.name + ' se comunicará con vos a la brevedad.'

          } else {

            this.resetAllPopUp()
            this.closePopUpLogin()
            this.errors.push('Hubo un error. Verifique los datos e intente nuevamente.')

          }


        })
        .catch(error => {

          this.errors.push('Existe un problema en el servidor. Intente mas tarde por favor')

        })
      }


    }

  },
  computed: {

    filterEpisodesByUnit: function() {
      return this.episodes.filter((episode) => episode.unit_id == this.currentUnit)
    },

    percentComplete() {
      // return await parseInt( this.authUser.authorized_units / Object.keys(this.units).length )
      return 60
    }

  }
});
