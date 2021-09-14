<?php 

	if ( empty($_GET) || !isset($_GET['selector']) || !isset($_GET['validator']) || !isset($_GET['id']) ) {
		header('Location: ./');
	}

	include_once __DIR__ . '/includes/soporte.php';
	include_once __DIR__ . '/includes/functions.php';

	$user_id = $reset = $db->getRepositorioUsers()->resetPassword($_GET['selector'], $_GET['validator'] , $_GET['id'] );
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
	<link rel="stylesheet" href="./css/modales-compartidos-front-back.css">
	<link rel="stylesheet" href="css/app.css">
</head>
<body>

	<div id="app">

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
			<img class="img-fluid image_no_shadow_rounded" src="img/home/header.jpg" alt="header ontarget">
		</header>
		<!-- Header end -->

		<section class="reset">

			<div class="container">
				<div class="row">
					<div class="col-md-6 mx-auto">

						<!-- Msg -->
						<?php include('includes/msg.php'); ?>

						<!-- Errores -->
						<?php include('includes/errors.php'); ?>

						<form id="newPass" method="post">

							<input type="hidden" name="user_id" value="<?= $user_id ?>">

							<!-- Password -->
						  <div class="form-group">
						    <label for="password_reset">Password</label>
						    <input 
							    type="password" 
							    class="form-control" 
							    v-model="password_reset"
						    >
						  </div>
							<!-- Password end -->

							<!-- Repetir Password -->
						  <div class="form-group">
						    <label for="cpassword_reset">Repeti el password</label>
						    <input 
							    type="password" 
							    class="form-control" 
						    	v-model="cpassword_reset"
					    	>
						  </div>
							<!-- Repetir Password end -->
						  	
						  <div class="text-center">
						  	<button id="btnNewPAss" @click.prevent="resetPass" class="btn btn--alpha"><span>Resetear Contraseña</span></button>
						  </div>
						</form>

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

<?php 
echo "
	<script>
		app.user_id = ". $user_id .";
	</script>
	";
?>

</html>