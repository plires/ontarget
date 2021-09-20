<div class="modal fade" id="modalUnitsAuthorized" tabindex="-1" aria-labelledby="modalUnitsAuthorizedLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalUnitsAuthorizedLabel">Datos del Usuario: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="card card-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header">
            <div>
              <i class="fas fa-user-graduate"></i>
            </div>

            <div>
              <h3 class="widget-user-username">{{ showingUser.name }}</h3>
              <h5 class="widget-user-desc">Estudiante</h5>
            </div>
          </div>

          <div class="card-footer">
            <div class="form-group">
              <label for="selectAuthorizedUnits">Este usuario esta autorizado hasta la <code>unidad {{ showingUser.authorized_units }}</code></label>
              <select id="selectAuthorizedUnits" class="custom-select form-control-border border-width-2">
                <option :value="item" v-for="item in totalUnits">Unidad {{ item }}</option>
              </select>
            </div>

            <div class="form-group">
              <button 
                @click="changeUnitsAuthorized(showingUser.id)" 
                type="button" 
                class="comentario_leido btn btn-outline-primary btn-block">
                  <i class="far fa-check-square"></i> Autorizar
              </button>
            </div>


          </div>

        </div>

      </div>

    </div>
  </div>
</div>