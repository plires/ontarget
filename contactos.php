<?php
$name = '';
$lastname = '';
$email = '';
$phone = '';
$comments = '';
$origin = 'Formulario de Contacto Web';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bienvenido al Método OnTarget, Contactate con nosotros por cualquier inquietud.">
	<title>Ontarget - Contactos | OnTarget</title>

	<!-- Favicons -->
	<?php include('includes/favicon.php'); ?>

	<link rel="stylesheet" type="text/css" href="./node_modules/normalize.css/normalize.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/all.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./node_modules/aos/dist/aos.css"/>
	<link rel="stylesheet" href="css/app.css">
</head>
<body>

	<!-- Nav -->
	<?php include('includes/nav.php'); ?>

	<section class="contacto">

		<div class="bg_gris">

			<!-- Header Contacto -->
			<section class="header_contacto container-fluid">
				<div class="container">
					<div class="row">

						<div class="col-md-6">
							<h1 data-aos="fade-up">
								En OnTarget somos un gran equipo y podes formar parte de él. Es tu oportunidad. ¡Sumate!
							</h1>
						</div>

						<div class="col-md-6">
							<img data-aos="fade-up" class="img-fluid image_no_shadow_rounded" src="img/contacto/chica-telefono.png" alt="chica telefono ontarget">
						</div>
						
					</div>
				</div>
			</section>
			<!-- Header Contacto end -->

			<!-- Formulario -->
			<section data-aos="fade-up" class="formulario container">
				<div class="row">

					<div class="col-md-12">

						<h2>Contactanos</h2>

						<form method="post" class="needs-validation" novalidate>

							<input type="hidden" value="<?= $origin ?>">

						  <div class="form-row">
								<!-- Nombre -->
						    <div class="form-group col-md-6">
						      <label for="name">Nombre</label>
						      <input required type="email" class="form-control" id="name" name="name" placeholder="Nombre" value="<?= $name ?>">
						      <div class="invalid-feedback">
					          Ingresá tu nombre
					        </div>
						    </div>
								<!-- Nombre end -->

								<!-- Apellido -->
						    <div class="form-group col-md-6">
						      <label for="lastname">Apellido</label>
						      <input required type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellido" value="<?= $lastname ?>">
						      <div class="invalid-feedback">
					          Ingresá tu apellido
					        </div>
						    </div>
								<!-- Apellido end -->
						  </div>

						  <div class="form-row">
						  	<!-- Email -->
						    <div class="form-group col-md-6">
						      <label for="email">Email</label>
						      <input required type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $email ?>">
						      <div class="invalid-feedback">
					          Ingresá tu email
					        </div>
						    </div>
								<!-- Email end -->

								<!-- Telefono -->
						    <div class="form-group col-md-6">
						      <label for="phone">Telefono</label>
						      <input required type="text" class="form-control" id="phone" name="phone" placeholder="Telefono" value="<?= $phone ?>">
						      <div class="invalid-feedback">
					          Ingresá tu teléfono
					        </div>
						    </div>
								<!-- Telefono end -->
							</div>

							<div class="form-row">
								<!-- Comentarios -->
						    <div class="form-group col-md-12">
						      <label for="comments">Comentarios</label>
						      <textarea required class="form-control" name="comments" id="comments" placeholder="Escribí tu consulta"></textarea>
							    <div class="invalid-feedback">
							      Tus comentarios son importantes
							    </div>
						    </div>
								<!-- Comentarios end -->
						  </div>

						  <div class="form-group">
						    <div class="form-check">
						      <input checked class="form-check-input" type="checkbox" name="newsletter" id="newsletter">
						      <label class="form-check-label" for="newsletter">
						        suscribe newsletter
						      </label>
						    </div>
						  </div>

						  <div class="text-center">
						  	<button type="submit" class="btn btn--alpha"><span>Enviar</span>
						  </div>

						</form>

					</div>

				</div>
			</section>
			<!-- Formulario end -->

			<!-- Nuestros Canales -->
			<section class="nuestros_canales container-fluid">
				<div class="container">
					<div class="row">

						<div class="col-md-12">
							<h2>Nuestros Canales</h2>

							<div class="datos">

								<div class="content_mail">
									<img class="img-fluid image_no_shadow_rounded" src="img/contacto/icono-mail.png" alt="icono mail">
									<div class="mail">
										<a class="transition" href="mailto:contacto@ontarget.com.ar">contacto@ontarget.com.ar</a>
										<a class="transition" href="mailto:rrhh@ontarget.com.ar">rrhh@ontarget.com.ar</a>
									</div>									
								</div>

								<div class="content_telefono">
									<img class="img-fluid image_no_shadow_rounded" src="img/contacto/icono-telefono.png" alt="icono telefono">
									<div class="telefono">
										<a class="transition" href="tel:1132136129">11 3213 6129</a>
									</div>									
								</div>

							</div>

						</div>

					</div>
				</div>
			</section>
			<!-- Nuestros Canales end -->

		</div>

	</section>

	<!-- Footer -->
	<?php include('includes/footer.php'); ?>

</body>
<script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
<script type="text/javascript" src="js/app.js"></script>

</html>