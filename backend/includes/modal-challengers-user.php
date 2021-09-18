<div class="modal fade" id="modalChallengersUser" tabindex="-1" aria-labelledby="modalChallengersUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalChallengersUserLabel">Desafios Pendientes de Aprobación: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>

          <div v-if="challengesOfTheCurrentUser.length != 0" class="card-body">

            <div v-for="(challenge, index) in challengesOfTheCurrentUser" :key="index" class="contentChallengers">
              <h5>Unidad {{ challenge.unit_number }} - Capitulo {{challenge.episode_number }}</h5>
              <h5>Fecha de Entrega: {{ moment(challenge.created_at).format('DD-MM-YYYY') }} - 
                <span>{{ moment(challenge.created_at).fromNow() }}</span>
              </h5>
              <h6>Comentarios del usuario para esta entrega:</h6>
              <p>{{ challenge.comments }}</p>

              <div v-if="challenge.files.length != 0">
                <a 
                  v-for="(file, index_file) in challenge.files" 
                  :key="index_file" 
                  class="contentFiles"
                  :href="file" 
                  download 
                >
                  <i class="far fa-file"></i>
                </a>
              </div>

              <div v-else>
                <p>
                  Los archivos para descargar deberían estar aquí ya que es obligatorio para el usuario. Por algún motivo no se pudieron cargar. Por favor ponete en contacto con <strong>{{ showingUser.name }}</strong> al 
                  <a :href="'mailto:' + showingUser.email">{{ showingUser.email }}</a> y cosultale por estos archivos.
                </p>
              </div>

            </div>

          </div>

          <div v-else class="card-body">
              <p>No hay desafios pendientes de corrección para este usuario.</p>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>