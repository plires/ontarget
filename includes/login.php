<!-- Login -->

<section id="login" class="transition">

	<div @click="closePopUpLogin" class="overlay_login"></div>

	<!-- Formulario Login -->
	<div v-if="loginContent" class="content_login">

		<!-- Errores -->
		<?php include('errors.php'); ?>

		<form id="formLogin" method="post">

			<!-- Email -->
		  <div class="form-group">
		    <label for="email">Correo electrónico</label>
		    <input type="email" class="form-control" id="email" name="email" v-model="email">
		  </div>
			<!-- Email -->

			<!-- Pass -->
		  <div class="form-group">
		    <label for="password">Contraseña</label>
		    <input type="password" class="form-control" id="password" name="password" v-model="password">
		  </div>
			<!-- Pass end -->

		  <button id="btnLogin" @click.prevent="login" class="btn btn--alpha"><span>Iniciar sesión</span></button>

		</form>

		<div class="otras_operaciones text-center">
			<p>¿No tienes una cuenta? <span @click="openPopUpRegister" class="transition">Regístrate gratis</span></p>
			<span class="transition" @click="openPopUpNewPass">¿Olvidaste tu contraseña?</span>
		</div>

	</div>
	<!-- Formulario Login end -->

	<!-- Formulario Register -->
	<div v-if="registerContent" class="content_login">

		<!-- Msgs -->
		<?php include('msg.php'); ?>

		<!-- Errors -->
		<?php include('errors.php'); ?>

		<form id="formRegister" method="post">

			<!-- Nombre -->
		  <div class="form-group">
		    <label for="name">Nombre</label>
		    <input type="text" class="form-control" id="name" name="name" v-model="name">
		  </div>
			<!-- Nombre -->

			<!-- Email -->
		  <div class="form-group">
		    <label for="email">Correo electrónico</label>
		    <input type="email" class="form-control" id="email" name="email" v-model="email">
		  </div>
			<!-- Email -->

			<!-- Teléfono -->
		  <div class="form-group">
		    <label for="phone">Teléfono</label>
		    <input type="tel" class="form-control" id="phone" name="phone" v-model="phone">
		  </div>
			<!-- Teléfono -->

			<!-- Pass -->
		  <div class="form-group">
		    <label for="password">Contraseña</label>
		    <input type="password" class="form-control" id="password" name="password" v-model="password">
		  </div>
			<!-- Pass end -->

			<!-- CPass -->
		  <div class="form-group">
		    <label for="cpassword">Repetir contraseña</label>
		    <input type="password" class="form-control" id="cpassword" name="cpassword" v-model="cpassword">
		  </div>
			<!-- CPass end -->

		  <button id="btnRegister" @click.prevent="register" class="btn btn--alpha"><span>Registrarse</span></button>

		</form>

		<div class="otras_operaciones text-center">
			<p>¿Ya tienes cuenta? <span @click="openPopUpLogin" class="transition">Inicia sesión</span></p>
		</div>

	</div>
	<!-- Formulario Register end -->

	<!-- Formulario Nuevo Pass -->
	<div v-if="newPasswordContent" class="content_login">

		<!-- Msgs -->
		<?php include('msg.php'); ?>

		<!-- Errors -->
		<?php include('errors.php'); ?>

		<form id="formRegister" method="post">

			<!-- Email -->
		  <div class="form-group">
		    <label for="email">Correo electrónico</label>
		    <input type="email" class="form-control" id="email" name="email" v-model="email">
		  </div>
			<!-- Email -->

		  <button id="btnNewPass" @click.prevent="forgotPassword" class="btn btn--alpha"><span>Recuperar Contraseña</span></button>

		</form>

		<div class="otras_operaciones text-center">
			<p>¿No tienes una cuenta? <span @click="openPopUpRegister" class="transition">Regístrate gratis</span></p>
			<span class="transition"  @click="openPopUpLogin">También puedes iniciar sesión</span>
		</div>

	</div>
	<!-- Formulario Nuevo Pass end -->

</section>

<!-- Login end -->
