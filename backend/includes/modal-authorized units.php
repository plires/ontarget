<div class="modal fade" id="modalAuthorizedUnits" tabindex="-1" aria-labelledby="modalAuthorizedUnitsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalAuthorizedUnitsLabel">Datos del Usuario: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>
          <div class="card-body">

            <!-- Nombre -->
            <div class="form-group">
              <label>Nombre</label>
              <input disabled v-model="showingUser.name" type="text" class="form-control">
            </div>
            <!-- Nombre end -->

            <!-- Email -->
            <div class="form-group">
              <label>Email</label>
              <input disabled v-model="showingUser.email" type="text" class="form-control">
            </div>
            <!-- Email end -->

            <!-- Teléfono -->
            <div class="form-group">
              <label>Teléfono</label>
              <input disabled v-model="showingUser.phone" type="text" class="form-control">
            </div>
            <!-- Teléfono end -->

            <!-- Unidades Autorizadas -->
            <div class="form-group">
              <label>Autorizado hasta la Unidad:</label>
              <input disabled v-model="showingUser.authorized_units" type="text" class="form-control">
            </div>
            <!-- Unidades Autorizadas end -->
          
          </div>

        </form>
      </div>

    </div>
  </div>
</div>