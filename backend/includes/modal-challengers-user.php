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

        <div v-if="challengesUnapprovedTheCurrentUser.length != 0" class="card-body">

          <div id="accordion">

            <div v-for="(challenge, index) in challengesUnapprovedTheCurrentUser" :key="index" class="card card-primary">
              
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
                    <dd v-if="challenge.files != null"  class="col-sm-8">
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

                    <dd style="display: inline-block;" v-else class="col-sm-8">
                      <p>No corresponde por tratarse de un desafío que debe resolverse en un zoom o comunicación con el usuario</p>
                      <a 
                        href="https://zoom.us/signin" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="comentario_leido btn btn-outline-primary btn-block mt-3">
                          <i class="fas fa-video transition"></i> Programar zoom
                      </a>
                    </dd>

                  </dl>

                  <button 
                    v-if="challenge.files != null" 
                    @click="markAsApprovedOneChallenge(challenge.id, index, challenge.user_id)" 
                    type="button" 
                    class="comentario_leido btn btn-outline-primary btn-block mt-5">
                      <i class="far fa-check-square"></i> Marcar como desafío aprobado
                  </button>

                  <button 
                    v-else
                    @click="markAsApprovedOneChallenge(challenge.id, index, challenge.user_id)" 
                    type="button" 
                    class="comentario_leido btn btn-outline-primary btn-block mt-5">
                      <i class="far fa-check-square"></i> Marcar como leído o tarea ejecutada
                  </button>

                  

                </div>
              </div>
            </div>

          </div>

          <button 
            @click="markAsApprovedAllChallengerFromThisUser(challengesOfTheCurrentUser[0].user_id)" 
            type="button" 
            class="todos_comentarios_leido btn btn-outline-primary btn-block mt-5">
              <i class="fas fa-check-double"></i> Marcar todos los desafíos como aprobados / recibidos
          </button>

        </div>

        <div v-else class="card-body">
            <p>No hay desafios pendientes de corrección para este usuario.</p>
        </div>

      </div>

    </div>
  </div>
</div>