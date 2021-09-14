<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bienvenido al Método OnTarget, Respuestas a las consultas mas frecuentes que podes tener.">
	<title>Ontarget - FAQ | OnTarget</title>

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

		<!-- Msgs -->
		<?php include('includes/msg.php'); ?>

		<!-- Errors -->
		<?php include('includes/errors.php'); ?>

		<!-- Login -->
		<?php include('includes/login.php'); ?>

		<!-- Nav -->
		<?php include('includes/nav.php'); ?>

		<section class="faqs">

			<div class="bg_gris">

				<!-- Header Preguntas Frecuentes -->
				<section class="header_frecuentes container-fluid text-center">
					<div class="container">
						<div class="row">

							<div class="col-md-5">
								<h1 data-aos="fade-up">Preguntas Frecuentes</h1>
							</div>

							<div class="col-md-7">
								<img data-aos="fade-up" class="img-fluid image_no_shadow_rounded" src="img/faq/chica-tablet.png" alt="chica tablet ontarget">
							</div>
							
						</div>
					</div>
				</section>
				<!-- Header Preguntas Frecuentes end -->

				<!-- Preguntas y Respuestas -->
				<section class="preguntas_respuestas container text-center">
					<div class="row">

						<div class="col-md-12">

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_1" role="button" aria-expanded="false" aria-controls="pregunta_1">
									<span>01</span>
									<p>¿Cuáles son los requisitos para la inscripción y cúal es el costo?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_1">
						      <div class="card card-body">
						        El Método Ontarget es  totalmente GRATUITO. Enfocado en todas las personas que les interesa desafiarse y crecer profesionalmente.
						      </div>
						    </div>
							</div>

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_2" role="button" aria-expanded="false" aria-controls="pregunta_2">
									<span>02</span>
									<p>¿Existe un límite de cupos?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_2">
						      <div class="card card-body">
						        Podés empezar en el momento que lo desees, no es necesario esperar a cierta cantidad de inscriptos para iniciar tus desafíos.
						      </div>
						    </div>
							</div>

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_3" role="button" aria-expanded="false" aria-controls="pregunta_3">
									<span>03</span>
									<p>¿Cuenta con un horario de cursada?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_3">
						      <div class="card card-body">
						        Nuestro método de aprendizaje es 100% online, contando con la posibilidad de que lo hagas adaptándolo al horario que más te convenga.
						      </div>
						    </div>
							</div>

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_4" role="button" aria-expanded="false" aria-controls="pregunta_4">
									<span>04</span>
									<p>¿Cuenta con seguimiento personalizado o es solamente mediante videos?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_4">
						      <div class="card card-body">
						        El método está adaptado a tus necesidades para un mejor aprendizaje mediante videos de entre 5” / 7” minutos y para que puedas abordar dudas o consultas contas con un asesor que te dará apoyo durante todo el proceso. 
						      </div>
						    </div>
							</div>

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_5" role="button" aria-expanded="false" aria-controls="pregunta_5">
									<span>05</span>
									<p>¿Cómo evalúan el aprendizaje?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_5">
						      <div class="card card-body">
						        Nuestro equipo de asesores se encargan de hacer la devolución de desempeño respecto a los ejercicios hechos en cada unidad finalizada, para luego ir avanzando en la siguiente unidad del método. 
						      </div>
						    </div>
							</div>

							<div class="faq" data-aos="fade-up">
								<div class="pregunta" data-toggle="collapse" href="#pregunta_6" role="button" aria-expanded="false" aria-controls="pregunta_6">
									<span>06</span>
									<p>¿Otorgan certificado al finalizarlo?</p>
								</div>

								<div class="respuesta collapse multi-collapse" id="pregunta_6">
						      <div class="card card-body">
						        En Ontarget ponemos a tu disposición el método de aprendizaje mediante videos cortos super didácticos. Recibirás un certificado siempre y cuando cumplas con la realización de todas las actividades brindadas en cada unidad. Lo importante es tu compromiso con vos mismo en aprender; superarte y llevarte el mejor CONOCIMIENTO.
						      </div>
						    </div>
							</div>

						</div>
						
					</div>
				</section>
				<!-- Preguntas y Respuestas end -->

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