<?php 

	if ( empty($_GET) || !isset($_GET['email']) || !isset($_GET['token']) ) {
		header('Location: ./');
	}

	include_once __DIR__ . '/includes/soporte.php';
	include_once __DIR__ . '/includes/functions.php';

	$user = $db->getRepositorioUsers()->verifyTokenNewEmail($_GET['email'], $_GET['token'] );

	if ($user) {
		$msg = '
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  <strong>Correo Verificado</strong> <br>Usuario Habilitado
			  <button @click="cleanMsgs()" type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
	} else {
		header('Location: ./');
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Tag Manager Head -->
	<?php include_once("./includes/tag_manager_head.php"); ?>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Nuestro Método On Target es un camino sólido para la formación de nuevos profesionales en el mercado asegurador. Seccion de verificacion de casilla de correo del usuario">
	<title>Ontarget - Usuario Verificado</title>

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
	<!-- Tag Manager Body -->
	<?php include_once("./includes/tag_manager_body.php"); ?>
	
	<div id="app">

		<div id="loading" class="lds-ring"><div></div><div></div><div></div><div></div></div>

		<?php $current = 'verify'; ?>

		<!-- Login -->
		<?php include('includes/login.php'); ?>
		
		<!-- Nav -->
		<?php include('includes/nav.php'); ?>

		<!-- Modal Perfil Usuario -->
	    <?php include('includes/modal-perfil.php'); ?>

	    <!-- Modal Contactar a tu Team Leader -->
	    <?php include('includes/modal-contact-team-leader.php'); ?>

		<!-- Header -->
		<header>
			<img class="img-fluid image_no_shadow_rounded" src="img/email-verified/header-verified.jpg" alt="header email verified">
		</header>
		<!-- Header end -->

		<section class="verify">

			<div class="container">
				<div class="row">
					<div class="col-md-6 mx-auto">

						<?php if (isset($msg)): ?>
							<?= $msg; ?>
						<?php endif ?>

					</div>
				</div>
			</div>

			<div class="container">
				<div class="row mt-5 mb-5">
					<div class="col-md-8 mx-auto">
						<p>
							Felicitaciones, estas listo para comenzar a ver nuestra primera unidad del método On Target. <br>
							Hace Login y comenzá ya mismo.
						</p>
					</div>

					<div class="col-md-12 text-center">
						<a class="transition" href="./" id="btnVerify">
							Comenzar
						</a>
					</div>
				</div>
			</div>

		</section>

		<!-- Footer -->
		<?php include('includes/footer.php'); ?>
	
	</div>

	<script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
	<script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
	<script type="text/javascript" src="./node_modules/vue/dist/vue.js"></script>
	<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
	<script type="text/javascript" src="js/nav/vue-nav.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
</body>

</html>