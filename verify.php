<?php 

	if ( empty($_GET) || !isset($_GET['email']) || !isset($_GET['token']) ) {
		header('Location: ./');
	}

	include_once __DIR__ . '/includes/soporte.php';
	include_once __DIR__ . '/includes/functions.php';

	$user = $reset = $db->getRepositorioUsers()->verifyTokenNewEmail($_GET['email'], $_GET['token'] );

	if ($user) {
		$msg = '
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  <strong>Correo Verificado</strong> <br>Usuario Habilitado
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Nuestro Método On Target es un camino sólido para la formación de nuevos profesionales en el mercado asegurador. Seccion de recuperacion de contraseña">
	<title>Ontarget - Reset Password</title>

	<!-- Favicons -->
	<?php include('includes/favicon.php'); ?>

	<link rel="stylesheet" type="text/css" href="./node_modules/normalize.css/normalize.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/all.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/aos/dist/aos.css"/>
	<link rel="stylesheet" href="css/app.css">
</head>
<body>

	<div id="app">

		<!-- Login -->
		<?php include('includes/login.php'); ?>
		
		<!-- Nav -->
		<?php include('includes/nav.php'); ?>

		<!-- Header -->
		<header>
			<img class="img-fluid image_no_shadow_rounded" src="img/home/header.jpg" alt="header ontarget">
		</header>
		<!-- Header end -->

		<section class="verify">

			<div class="container">
				<div class="row">
					<div class="col-md-6 mx-auto">

						<?= $msg; ?>

					</div>
				</div>
			</div>

		</section>

		<!-- Footer -->
		<?php include('includes/footer.php'); ?>
	
	</div>

	<script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
	<script type="text/javascript" src="./node_modules/vue/dist/vue.js"></script>
	<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/nav/vue-nav.js"></script>
</body>

</html>