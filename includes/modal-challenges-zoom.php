<div class="modal fade modal_ontarget" id="modalChallengeZoom" tabindex="-1" aria-labelledby="modalChallengeZoomLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalChallengeZoomLabel">Desafío: {{ currentChallenge.name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><strong>¿De que se trata este desafío?</strong></h6>
        <p class="description" v-html="currentChallenge.description"></p>
        
        <h6><strong>¿Como lo completo?</strong></h6>

        <p class="description">Fácil, en 3 simples pasos:</p>

        <a class="pasos transition" :href="'./challenges/' + currentChallenge.url_download">
          <span>1 -</span>Descargá los archivos base
          <i class="transition fas fa-cloud-download-alt"></i>
        </a>

        <p class="pasos"><span>2 -</span>Completa el desafío <i class="transition fas fa-check-circle"></i></p>

        <p class="pasos"><span>3 -</span>Solicitá reunión vía Zoom. <i class="fas fa-video transition"></i></p>

        <div class="text-center">
          <button @click="openModalZoomRequest" class="btn btn-desafio">
            Solicitar Reunión&nbsp;&nbsp;
            <i class="fas fa-comments transition"></i>
          </button>
        </div>

      </div>

    </div>
  </div>
</div>