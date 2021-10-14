<div class="modal fade modal_ontarget" id="modalZoomRequest" tabindex="-1" aria-labelledby="modalZoomRequestLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalZoomRequestLabel">Solicitá un Zoom a {{ teamLeader.name }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="description">Completá el siguiente campo para solicitar un zoom a {{ teamLeader.name }}. No olvides colocar tus días y horarios disponibles</p> <br>

        <form id="formZoomRequest" method="post">

          <div class="form-group">
            <h6>Solicitud:</h6>
            <textarea name="commentsRequestZoom" class="form-control" id="commentsRequestZoom" rows="5"></textarea>
          </div>

          <div class="text-right">
            <button @click.prevent="sendRequestZoom" class="btn btn-desafio">Solicitar</button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>