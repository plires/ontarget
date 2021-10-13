<div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUploadLabel">Subí los desafios realizados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Si te equivocaste al subir algún archivo podes hacerlo nuevamente y la entrega se actualizará con el nuevo material. Esto sólo es posible si tu Team Leader aún no vio y corrigió el desafio.</p> <br>
        <h6>Subir Archivos</h6>

        <form name="formUpload" id="formUpload" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <div class="custom-file">
              <input 
                type="file" 
                class="custom-file-input" 
                id="challengerFile" 
                multiple=""
              >
              <label class="custom-file-label" for="challengerFile">Elegir archivo</label>
            </div>
          </div>

          <div class="form-group">
            <h6>Podes dejar un comentario opcional</h6>
            <textarea name="comments" class="form-control" id="comments" rows="3"></textarea>
          </div>

          <button @click.prevent="uploadChallenger" class="btn btn-primary">Subir</button>

        </form>

      </div>

    </div>
  </div>
</div>