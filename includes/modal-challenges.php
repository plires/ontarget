<div class="modal fade" id="modalChallenge" tabindex="-1" aria-labelledby="modalChallengeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalChallengeLabel">Desafío: {{ currentChallenge.name }}</h5>
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
          <span>1 -</span>Descargá los archivos
          <i class="transition fas fa-cloud-download-alt"></i>
        </a>

        <p class="pasos"><span>2 -</span>Completa el desafío <i class="transition fas fa-check-circle"></i></p>

        <a @click="openModalUploadChallenge" class="pasos transition" href="#">
          <span>3 -</span>Subí los archivos
          <i class="fas fa-cloud-upload-alt"></i>
        </a>

      </div>

    </div>
  </div>
</div>