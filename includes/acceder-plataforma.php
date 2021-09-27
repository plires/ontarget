<!-- Accede a nuestra plataforma -->
<section class="accede container-fluid">
  <div class="container h-100">
    <div class="row h-100">
      <div class="col-md-8 m-auto h-100">
        <h2>Accedé a nuestra Plataforma de aprendizaje</h2>
        <p class="frase">
          Sólo necesitas un usuario y contraseña y obtendrás acceso al Método OnTarget, Webinars, Eventos y mucho más para comenzar tu momento de cambio PROFESIONAL.
        </p>

        <button v-if="Object.keys(authUser).length === 0" @click="openPopUpLogin" class="btn btn--alpha">
          <span>Hazte miembro ahora</span>
        </button>

        <button v-else class="btn btn--alpha" @click="openPopUpAcount">
          <span>Hazte miembro ahora</span>
        </button>
        
      </div>
    </div>
  </div>
</section>
<!-- Accede a nuestra plataforma end -->