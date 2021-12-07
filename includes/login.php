	<!-- Login -->

	<section id="login" class="transition">

		<div @click="closePopUpLogin" class="overlay_login"></div>

		<!-- Formulario Login -->
		<div v-if="loginContent" class="content_login">

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

				<!-- Ciudad -->
				<div class="form-group">
					<label for="phone">Ciudad</label>
					<input type="text" class="form-control" id="city" name="city" v-model="city">
				</div>
				<!-- Ciudad -->

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

				<!-- Mayor de 21 -->
				<div class="form-check mb-3">
					<input type="checkbox" class="form-check-input" id="mayor_edad" name="mayor_edad" v-model="mayor_edad">
					<label class="form-check-label" for="mayor_edad">soy mayor de 21 años</label>
				</div>
				<!-- Mayor de 21 end -->

			  <button id="btnRegister" @click.prevent="register" class="btn btn--alpha"><span>Registrarse</span></button>

			</form>

			<div class="otras_operaciones text-center">
				<p>¿Ya tienes cuenta? <span @click="openPopUpLogin" class="transition">Inicia sesión</span></p>
			</div>

		</div>
		<!-- Formulario Register end -->

		<!-- Formulario Nuevo Pass -->
		<div v-if="newPasswordContent" class="content_login">

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

		<!-- Cuenta de usuario -->
		<div v-if="accountContent" class="content_login content_account">

			<ul>
				<li>
					<div class="user">
						<p class="name" v-cloak><span class="icon">{{ authUser.name.charAt(0) }}</span>{{ authUser.name }}</p>
					</div>
				</li>
				<li>
					<a class="transition" href="<?= BASE ?>dashboard.php"><i class="fas fa-columns"></i>Dashboard</a>
				</li>
				<li>
					<button 
						@click="openModalContatcYourTeamLeader" 
						class="transition">
							<i class="far fa-question-circle"></i>
							Contactá a tu Team Leader
					</button>
				</li>
				<li>
					<button 
						@click="openModalPerfilUsuario" 
						class="transition">
							<i class="fas fa-user-cog"></i>
							Perfil
					</button>
				</li>
				<li>
					<a 
						@click="clearLocalStorage" 
						class="transition salir" 
						href="./../php/logout.php"
					><i class="fas fa-sign-out-alt"></i>Salir</a>
				</li>
			</ul>

		</div>
		<!-- Cuenta de usuario end -->

	</section>

	<!-- Login end -->
