<?php
session_start();

  require ('includes/config.inc.php');

  if ( !isset($_SESSION['user']) ) {
    session_destroy();
    header('Location: ./');
  }
  
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Tag Manager Head -->
	<?php include_once("./includes/tag_manager_head.php"); ?>
	
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | OnTarget</title>

  <!-- Favicons -->
  <?php include('includes/favicon.php'); ?>

  <link rel="stylesheet" type="text/css" href="./node_modules/normalize.css/normalize.css">
  <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/all.css">
  <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./node_modules/slick-carousel/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="./node_modules/slick-carousel/slick/slick-theme.css"/>
  <link rel="stylesheet" type="text/css" href="./node_modules/aos/dist/aos.css"/>
  <link rel="stylesheet" href="./node_modules/admin-lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="./css/modales-compartidos-front-back.css">

  <link rel="stylesheet" href="css/app-dashboard.css">

</head>

<!--
`body` tag options:
  Apply one or more of the following classes to to the body tag
  to get the desired effect
  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">

  <!-- Tag Manager Body -->
  <?php include_once("./includes/tag_manager_body.php"); ?>

  <div id="app">

    <div id="loading" class="lds-ring"><div></div><div></div><div></div><div></div></div>

    <?php $current = 'dashboard'; ?>

    <div class="wrapper">

      <!-- Login -->
      <?php include('includes/login.php'); ?>

      <!-- Modal Contactar a tu Team Leader -->
      <?php include('includes/modal-contact-team-leader.php'); ?>

      <!-- Modal Perfil Usuario -->
      <?php include('includes/modal-perfil.php'); ?>
      
      <!-- Errores -->
      <?php include('includes/errors.php'); ?>

      <!-- Msg -->
      <?php include('includes/msg.php'); ?>

      <!-- Nav -->
      <?php include('includes/nav.php'); ?>

      
      <!-- Nav Dashboard -->
      <?php include('includes/dashboard/nav.php'); ?>

      <!-- Aside Dashboard Left -->
      <?php include('includes/dashboard/aside-left.php'); ?>

      <!-- Aside Right -->
      <?php // include('includes/dashboard/aside-right.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper welcome">
        
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <h1 class="m-0">¡Te damos la Bienvenida {{ authUser. name }}!</h1>
              </div>
            </div>
          </div>
        </div>
       
        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-7">
                <p>
                  La plataforma de aprendizaje en línea de <strong>OnTarget</strong> combina el poder del microaprendizaje diario, la tecnología, actualidad y el apoyo del equipo de <strong>WG SA</strong> para lograr una transformación personal y profesional que no podrás igualar con la formación tradicional.
                </p>

                <p>
                  En cada unidad encontraran ejercicios que permiten evaluar los resultados del conocimiento y poder así obtener los mejores resultados para tus metas y necesidades.
                </p>

                <p class="destacado">
                  Con solo 15 min. al día, vivirás un crecimiento personal y profesional que cambiará tu vida y tu futuro. Gozando del apoyo, la motivación y amistad de nuestro equipo.
                </p>

                <p class="destacado">
                  ¿Lo mejor? Estamos juntos para planificar tu futuro.
                </p>
              </div>

              <div class="col-md-5 text-center">
                <img class="img-fluid" src="./backend/img/dashboard/pantalla-bienvenida.png" alt="chica ontarget dashboard">
              </div>

            </div>

          </div>

        </div>

      </div>

      <!-- Footer Admin -->
      <?php include('includes/dashboard/footer-dashboard.php'); ?>

    </div>

  </div>

  <script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script type="text/javascript" src="./node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script type="text/javascript" src="./node_modules/admin-lte/dist/js/adminlte.min.js"></script>
  <script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
  <script type="text/javascript" src="./node_modules/vue/dist/vue.min.js"></script>
  <script type="text/javascript" src="./node_modules/slick-carousel/slick/slick.js"></script>
  <script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
  <script type="text/javascript" src="js/app.js"></script>

  <script type="text/javascript" src="js/slick-home.js"></script>
  <script type="text/javascript" src="js/nav/vue-nav.js"></script>

</body>
</html>
