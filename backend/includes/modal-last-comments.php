<div class="modal fade" id="modalLastComments" tabindex="-1" aria-labelledby="modalLastCommentsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalLastCommentsLabel">Comentarios Enviados por 
          <strong>{{ showingUser.name }}</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div v-if="commentsUnreadOfTheCurrentUser.length != 0" class="card-body">

          <div id="accordion">

            <div v-for="(comment, index) in commentsUnreadOfTheCurrentUser" :key="index" class="card card-primary">
              <div class="card-header">
                <h4 class="d-flex card-title w-100">
                  <a 
                    v-bind:class="[index == 0 ? '' : 'collapsed', 'd-block w-100']"
                    data-toggle="collapse" 
                    :href="'#comment-' + comment.id" 
                    aria-expanded="false">
                    {{ moment(comment.created_at).format('DD/MM/YYYY') }}
                  </a>
                  <span class="date_comment float-right badge bg-success">{{ moment(comment.created_at).fromNow() }}</span>
                </h4>
              </div>
              <div 
                :id="'comment-' + comment.id" 
                v-bind:class="[index == 0 ? 'show' : '', 'collapse']"
                data-parent="#accordion"
              >
                <div class="card-body">
                  <p>{{ comment.comment }}</p>
                  <button 
                    @click="MarkAsReadOneComment(comment.id, index, comment.user_id)" 
                    type="button" 
                    class="comentario_leido btn btn-outline-primary btn-block">
                      <i class="far fa-check-square"></i> Marcar como leído
                  </button>
                </div>
              </div>
            </div>

          </div>

          <button 
            @click="markAsReadAllMessagesFromThisUser(commentsOfTheCurrentUser[0].user_id)" 
            type="button" 
            class="todos_comentarios_leido btn btn-outline-primary btn-block mt-5">
              <i class="fas fa-check-double"></i> Marcar todos los comentarios leídos
          </button>

        </div>

        <div v-else class="card-body">
            <p>No hay comentarios sin leer para este usuario.</p>
        </div>

      </div>

    </div>
  </div>
</div>