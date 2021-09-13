<div class="modal fade" id="modalContactYourTeamLeader" tabindex="-1" aria-labelledby="modalContactYourTeamLeaderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalContactYourTeamLeaderLabel">Consultá a tu Team Leader</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <p>
          Tu Team Leader asignado es: <strong> {{ teamLeader.name }} </strong><br>
          Podés contactarlo en cualquier momento por dudas o consultas que puedas tener con la plataforma de aprendizaje de nuestro método.
        </p>

        <form name="formTeamLeader" id="formTeamLeader" method="post">

          <div class="form-group">
            <h6>Consulta:</h6>
            <textarea name="commentsToTeamLeader" class="form-control" id="commentsToTeamLeader" rows="6"></textarea>
          </div>

          <button @click.prevent="sendCommentsToTeamLeader" class="btn">Enviar</button>

        </form>

      </div>

    </div>
  </div>
</div>