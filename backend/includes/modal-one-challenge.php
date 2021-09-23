<div class="modal fade" id="modalOneChallenge" tabindex="-1" aria-labelledby="modalOneChallengeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalOneChallengeLabel">Desafío Entregado por 
          <strong>{{ showingUser.name }}</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="card-body">

          <dl class="row">

            <dt class="col-sm-4">Fecha de Subida:</dt>
            <dd class="col-sm-8">
              {{ moment(challenge.created_at).format('DD/MM/YYYY') }} - {{ moment(challenge.created_at).fromNow() }}&nbsp;  
            </dd>

            <dt class="col-sm-4">Horario de Subida:</dt>
            <dd class="col-sm-8"> {{ moment(challenge.created_at).format('hh:mm') }}</dd>

            <dt class="col-sm-4">Unidad:</dt>
            <dd class="col-sm-8">{{ challenge.unit_number }} </dd>

            <dt class="col-sm-4">Episodio:</dt>
            <dd class="col-sm-8">{{ challenge.episode_number }} </dd>

            <dt v-if="challenge.comments" class="col-sm-4">Comentario:</dt>
            <dd v-if="challenge.comments" class="col-sm-8">{{ challenge.comments }} </dd>

            <dt class="col-sm-4">Archivos Subidos</dt>
            <dd class="col-sm-8">
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

          </dl>

        </div>

        <div class="card-footer">
          <p>
              Podes dejarle una devolución a <strong>{{ showingUser.name }}</strong> haciendo 
              <a class="transition" :href="'mailto:' + showingUser.email + '?subject=On Target - Respuesta a desafío enviado el: ' + moment(challenge.created_at).format('DD/MM/YYYY') + '&body=Hola ' + showingUser.name + ', soy ' + authUser.name + ', tu Team Leader asignado para responder a todas tus consultas y darte devolución sobre estos desafíos entregados. %0A %0A El ' + moment(challenge.created_at).format('DD/MM/YYYY') + ' entregaste el desafío número ' + challenge.episode_number + ' de la unidad ' + challenge.unit_number + '. %0A %0A Te dejo mi devolución: %0A %0A' ">click aquí.</a>

            </p>
        </div>

      </div>

    </div>
  </div>
</div>