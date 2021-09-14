<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bienvenido al Método OnTarget, queremos presentarte a todo nuestro equipo, el que te va a guiar en cada paso del método.">
	<title>Ontarget - Quienes Somos? | OnTarget</title>

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

		<!-- Modal Perfil Usuario -->
	    <?php include('includes/modal-perfil.php'); ?>

	    <!-- Modal Contactar a tu Team Leader -->
	    <?php include('includes/modal-contact-team-leader.php'); ?>

		<section class="quienes_somos">

			<div class="bg_gris">

				<!-- Header -->
				<section class="header container-fluid text-center">
						<div class="row">
							<div class="col-md-12">

								<h1 data-aos="fade-up">Aprende de los mejores profesionales <br> el Método OnTarget</h1>
								<p data-aos="fade-up">
									OnTarget es el método de aprendizaje por excelencia del Grupo WGSA, es una compañía que nace de la visión de profesionales con espíritu emprendedor y amplia trayectoria en el mercado asegurador. Aquí se fusionan la experiencia de trabajo en un marco tradicional con un nuevo enfoque, más cálido y actual, en el que la prestancia y la comunicación con el cliente marcan la diferencia.
								</p>

							</div>
							
						</div>
				</section>
				<!-- Header end -->

				<!-- Equipo -->
				<section class="equipo container text-center">
					<div class="row">
						<div class="col-md-12">

							<p>
								Nuestro "Método OnTarget" es un camino sólido para la transformación de nuevos profesionales en el mercado asegurador, que se enfoca en brindar conocimientos en un ámbito de aprendizaje y contención constante para que cada nuevo miembro de la empresa pueda desarrollar todo su potencial profesional y personal. 
							</p>

						</div>
						
					</div>
				</section>
				<!-- Equipo end -->

				<!-- Equipo -->
				<?php include('includes/equipo.php'); ?>

				<!-- Acceder Plataforma -->
				<?php include('includes/acceder-plataforma.php'); ?>
				
			</div>

			<!-- Logos -->
			<?php include('includes/logos.php'); ?>

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