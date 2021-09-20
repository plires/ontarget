<div class="modal fade" id="modalChallengersUser" tabindex="-1" aria-labelledby="modalChallengersUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalChallengersUserLabel">Desafios Pendientes de Aprobación: 
          <strong>{{ showingUser.name }}</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div v-if="challengesOfTheCurrentUser.length != 0" class="card-body">

          <div id="accordion">

            <div v-for="(challenge, index) in challengesOfTheCurrentUser" :key="index" class="card card-primary">
              <div class="card-header">
                <h4 class="d-flex card-title w-100">
                  <a 
                    v-bind:class="[index == 0 ? '' : 'collapsed', 'd-block w-100']"
                    data-toggle="collapse" 
                    :href="'#desafio-' + challenge.id" 
                    aria-expanded="false">
                    Unidad {{ challenge.unit_number }} - Capitulo {{ challenge.episode_number }}
                    <span class="date_comment float-right badge bg-success">{{ moment(challenge.created_at).fromNow() }}</span>
                  </a>
                </h4>
              </div>
              <div 
                :id="'desafio-' + challenge.id" 
                v-bind:class="[index == 0 ? 'show' : '', 'collapse']"
                data-parent="#accordion"
              >
                <div class="card-body">

                  <dl class="row">

                    <dt class="col-sm-4">Fecha de Subida:</dt>
                    <dd class="col-sm-8">
                      {{ moment(challenge.created_at).format('DD/MM/YYYY') }}&nbsp;  
                    </dd>

                    <dt v-if="challenge.comments" class="col-sm-4">Comentarios del usuario para esta entrega:</dt>
                    <dd v-if="challenge.comments" class="col-sm-8">{{ challenge.comments }}</dd>

                    <dt class="col-sm-4">Archivos a Descargar</dt>
                    <dd v-if="challenge.files.length != 0"  class="col-sm-8">
                      <a 
                        v-for="(file, index_file) in challenge.files" 
                        :key="index_file" 
                        class="contentFiles transition"
                        :href="file" 
                        title="Descargar Desafío"
                        download 
                      >
                        <i class="far fa-file"></i>
                      </a>
                    </dd>

                    <dd v-else class="col-sm-8">
                      <p>
                        Los archivos para descargar deberían estar aquí ya que es obligatorio para el usuario. Por algún motivo no se pudieron cargar. Por favor ponete en contacto con <strong>{{ showingUser.name }}</strong> al 
                        <a :href="'mailto:' + showingUser.email">{{ showingUser.email }}</a> y cosultale por estos archivos.
                      </p>
                    </dd>

                  </dl>

                </div>
              </div>
            </div>

          </div>

        </div>

        <div v-else class="card-body">
            <p>No hay desafios pendientes de corrección para este usuario.</p>
        </div>

      </div>

    </div>
  </div>
</div>