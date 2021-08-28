<div v-if="errors.length > 0" class="alert alert-danger alert-dismissible fade show" role="alert">
  Por favor corregí la siguiente <strong>información</strong>
  <button @click="cleanErrors()" type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <ul>
    <li v-for="error in errors" v-cloak>- {{ error }}</li>
  </ul>
</div>