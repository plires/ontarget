<div class="modal fade" id="modalDataUser" tabindex="-1" aria-labelledby="modalDataUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalDataUserLabel">Datos del Usuario: </h5>
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
          <div class="card-footer p-0">
            <ul class="nav flex-column">
              <li class="nav-item">
                Nombre: <span class="float-right">{{ showingUser.name }}</span>
              </li>
              <li class="nav-item">
                Email: <span class="float-right">{{ showingUser.email }}</span>
              </li>
              <li class="nav-item">
                Team Leader: <span class="float-right">{{ showingUser.name_team_leader }}</span>
              </li>
              <li class="nav-item">
                Fecha de registro: <span class="float-right">{{ moment(showingUser.created_at).format('DD/MM/YYYY') }} - {{ moment(showingUser.created_at).fromNow() }}</span>
              </li>
            </ul>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>