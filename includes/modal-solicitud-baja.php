<div class="modal fade" id="modalSolicitudBaja" tabindex="-1" aria-labelledby="modalSolicitudBajaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSolicitudBajaLabel">Solicitud de baja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p>
          Al presionar en el botón "SOLICITO BAJA" estarás dejando constancia de tu voluntad a eliminar tu cuenta junto a cualquier información que encuentre en nuestra base de datos o en cualquier otro medio digital referido a tu persona.
        </p>

        <h6><span>Nombre:</span> {{name_user}}</h6>
        <h6><span>Email:</span> {{email_user}}</h6>
        <h6><span>Teléfono:</span> {{phone_user}}</h6>
        <h6><span>Ciudad:</span> {{city_user}}</h6>

      </div>

      <div class="modal-footer">
        <button @click.prevent="sendBaja(authUser.id)" class="btn btn-primary">SOLICITO BAJA</button>
      </div>

    </div>
  </div>
</div>