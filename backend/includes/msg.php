<div v-if=" msg != '' " class="alert alert-success alert-dismissible fade show msgs" role="alert">
  <strong>Información</strong>
  <button @click="cleanMsgs()" type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <p v-cloak>{{ msg }}</p>
</div>