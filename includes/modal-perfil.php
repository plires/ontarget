<div class="modal fade" id="modalPerfilUsuario" tabindex="-1" aria-labelledby="modalPerfilUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPerfilUsuarioLabel">Editá tu perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form name="formPerfilUsuario" id="formPerfilUsuario" method="post">

          <div class="form-group">
            <label for="nameUser">Nombre</label>
            <input type="text" class="form-control" name="nameUser" placeholder="Nombre" v-model="name_user">
          </div>

          <div class="form-group">
            <label for="emailUser">Email</label>
            <input type="email" class="form-control" name="emailUser" placeholder="Email" v-model="email_user">
          </div>

          <div class="form-group">
            <label for="phoneUser">Teléfono</label>
            <input type="tel" class="form-control" name="phoneUser" placeholder="Teléfono" v-model="phone_user">
          </div>

          <div class="form-group">
            <label for="cityUser">Ciudad</label>
            <input type="text" class="form-control" name="cityUser" placeholder="Buenos Aires" v-model="city_user">
          </div>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="passCheck" v-model="modeUserEdit">
              <label class="form-check-label" for="passCheck">
                Resetear contraseña
              </label>
            </div>
          </div>

          <div v-if="modeUserEdit" class="form-group">
            <label for="passwordUser">Password</label>
            <input type="password" class="form-control" name="passwordUser" placeholder="Password" v-model="password_user">
          </div>

          <div v-if="modeUserEdit" class="form-group">
            <label for="cPasswordUser">Repetí el password</label>
            <input type="password" class="form-control" name="cPasswordUser" placeholder="Repetí el Password" v-model="cPassword_user">
          </div>

          <button @click.prevent="sendUserEdit(authUser.id)" class="btn btn-primary">Guardar</button>

        </form>

      </div>

    </div>
  </div>
</div>