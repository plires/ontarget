<div class="modal fade" id="modalOneComment" tabindex="-1" aria-labelledby="modalOneCommentLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalOneCommentLabel">Comentario Enviado por 
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
              {{ moment(comment.created_at).format('DD/MM/YYYY') }} - {{ moment(comment.created_at).fromNow() }}&nbsp;  
            </dd>

            <dt class="col-sm-4">Horario de Subida:</dt>
            <dd class="col-sm-8"> {{ moment(comment.created_at).format('hh:mm') }}</dd>

            <dt class="col-sm-4">Comentario:</dt>
            <dd class="col-sm-8">{{ comment.comment }} </dd>

          </dl>

        </div>

        <div class="card-footer">
          <p>
              Podes contestarle a <strong>{{ showingUser.name }}</strong> haciendo  
              <a class="transition" :href="'mailto:' + showingUser.email + '?subject=On Target - Respuesta a tu comentario enviado el: ' + moment(comment.created_at).format('DD/MM/YYYY') + '&body=Hola ' + showingUser.name + ', soy ' + authUser.name + ', tu Team Leader asignado para responder a todas tus consultas. %0A %0A El ' + moment(comment.created_at).format('DD/MM/YYYY') + ' me enviaste este mensaje: %0A %0A' + comment.comment + '%0A %0A Te dejo mi respuesta: %0A %0A' ">click aquí.</a>

            </p>
        </div>

      </div>

    </div>
  </div>
</div>