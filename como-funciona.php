<?php require ('includes/config.inc.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bienvenido al Método OnTarget, queremos presentarte a todo nuestro equipo, el que te va a guiar en cada paso del método. Te explicamos en esta sección como funciona">
	<title>Ontarget - Como Funciona? | OnTarget</title>

	<!-- Favicons -->
	<?php include('includes/favicon.php'); ?>

	<link rel="stylesheet" type="text/css" href="./node_modules/normalize.css/normalize.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/all.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/aos/dist/aos.css"/>
	<link rel="stylesheet" href="./css/modales-compartidos-front-back.css">
	<link rel="stylesheet" href="css/app.css">
</head>
<body>

	<div id="app">

		<?php $current = 'como-funciona'; ?>

		<!-- Msgs -->
		<?php include('includes/msg.php'); ?>

		<!-- Errors -->
		<?php include('includes/errors.php'); ?>

		<!-- Login -->
		<?php include('includes/login.php'); ?>

		<!-- Nav -->
		<?php include('includes/nav.php'); ?>

		<!-- Modal Perfil Usuario -->
	    <?php include('includes/modal-perfil.php'); ?>

	    <!-- Modal Contactar a tu Team Leader -->
	    <?php include('includes/modal-contact-team-leader.php'); ?>

		<section class="funciona">

			<div class="bg_gris">

				<!-- Plan de estudios -->
				<section data-aos="fade-up" class="plan_estudios header container">
					<div class="row">
						
						<div class="col-md-12">
							<h1><span>Un plan de estudios adaptado <br>a tus metas, sueños e intereses</span></h1>
						</div>

						<div class="col-md-6">
							<img class="img-fluid image_no_shadow_rounded" src="img/como-funciona/telefono.png" alt="telefono">
						</div>

						<div class="col-md-6">
							<div class="faja_sobre_titulo_izq"></div>
							<p>
								<span>El método OnTarget</span> incluye acompañamiento constante de Team Leaders. En cada unidad  encontraran ejercicios que permiten evaluar los resultados del conocimiento y poder así obtener los mejores resultados para tus metas y necesidades. Podrás también, aprender a tu propio ritmo y personalizar tu aprendizaje.  
							</p>
						</div>

					</div>
				</section>
				<!-- Plan de estudios end -->

				<!-- Como Funciona -->
				<section data-aos="fade-up" class="como_funciona container">

					<img class="img-fluid puntos_left image_no_shadow_rounded" src="img/home/puntos.png" alt="puntos izquierda">
					<img class="img-fluid puntos_right image_no_shadow_rounded" src="img/home/puntos.png" alt="puntos derecha">

					<div class="row">
						<div class="col-md-12">
							<h2>¿Cómo Funciona?</h2>
							<p class="enunciado">
								Con solo 15 min. al día, vivirás un crecimiento personal y profesional que cambiará tu vida y tu futuro. Gozando del apoyo, la motivación y amistad de nuestro equipo. <br><br>
								¿Lo mejor? Estamos juntos para planificar tu futuro.
							</p>
							<img class="img-fluid image_no_shadow_rounded" src="img/como-funciona/compu.png" alt="compu">
							<p>
								La plataforma de aprendizaje en línea de OnTarget combina el poder del microaprendizaje diario, la tecnología, actualidad y el apoyo del equipo de WG SA para lograr una transformación personal y profesional que no podrás igualar con la formación tradicional.
							</p>
						</div>
					</div>
				</section>
				<!-- Como Funciona end -->

				<!-- Pasos -->
				<section data-aos="fade-up" class="pasos container">

					<div class="row">

						<div class="col-md-12 content_pasos">
							<p class="paso_numero">01</p>
							<h3>Realiza la inscripción</h3>
						</div>

						<div class="col-md-6">
							<img data-aos="flip-left" class="img-fluid" src="img/como-funciona/inscripcion.jpg" alt="inscripcion">
						</div>

						<div class="col-md-6">
							<p>
								El Método OnTarget es muy sensillo desde el paso 1. Solo debes ir a la sección de  "Inscripción", registrarte, luego recibirás un mail con acceso a la plataforma de aprendizaje y listo, ya estarás a bordo. Recuerda que siempre podrás aprender a tu propio ritmo y personalizar tu aprendizaje.
							</p>
						</div>

					</div>

					<div class="row">

						<div class="col-md-12 content_pasos cambiar_order">
							<p class="paso_numero paso_cambiar_orden">02</p>
							<h3>Inicia Sesión</h3>
						</div>

						<div class="col-md-6 pasos_textos">
							<p>
								Una vez dentro de la Plataforma de Aprendizaje de OnTarget se te asignará un Team Leader que siempre estará disponible para responder todas tus dudas y ayudarte a avanzar durante todo el proceso.
							</p>
						</div>

						<div class="col-md-6">
							<img data-aos="flip-left" class="img-fluid" src="img/como-funciona/sesion.jpg" alt="sesion">
						</div>

					</div>

					<div class="row">

						<div class="col-md-12 content_pasos">
							<p class="paso_numero">03</p>
							<h3>Únete a nuestro Equipo</h3>
						</div>

						<div class="col-md-6">
							<img data-aos="flip-left" class="img-fluid" src="img/como-funciona/unite.jpg" alt="unite">
						</div>

						<div class="col-md-6">
							<p>
								Nuestros Team Leaders te presentarán a nuestro equipo y podrás interactuar con otros estudiantes y hacer preguntas, iniciar debates, compartir publicaciones o simplemente encontrar un compañero de aprendizaje.
							</p>
						</div>

					</div>

					<div class="row">

						<div class="col-md-12 content_button">
							<button 
								v-if="Object.keys(authUser).length === 0" 
								@click="openPopUpRegister" 
								class="btn btn--alpha">
					          <span>Hazte miembro ahora</span>
					        </button>

					        <button v-else class="btn btn--alpha" @click="openPopUpAcount">
					          <span>Hazte miembro ahora</span>
					        </button>
						</div>


					</div>

				</section>
				<!-- Pasos end -->

			</div>

		</section>

	</div>

	<!-- Footer -->
	<?php include('includes/footer.php'); ?>

	<script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
	<script type="text/javascript" src="./node_modules/vue/dist/vue.js"></script>
	<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/nav/vue-nav.js"></script>
</body>

</html>