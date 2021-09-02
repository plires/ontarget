<?php
session_start();

if ( !isset($_SESSION['user']) ) {
  session_destroy();
  header('Location: ./');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
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

<div id="app" class="wrapper">
  
  <!-- Nav Dashboard -->
  <?php include('includes/dashboard/nav.php'); ?>

  <!-- Aside Dashboard Left -->
  <?php include('includes/dashboard/aside-left.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">¡Te damos la Bienvenida xxx!</h1>
          </div>
         
        </div>
      </div>
    </div>
   

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Capitulo 1</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" title="vimeo-player" src="https://player.vimeo.com/video/595545366?h=bf44df8e2d" width="640" height="360" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Capitulo 2</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" title="vimeo-player" src="https://player.vimeo.com/video/595545366?h=bf44df8e2d" width="640" height="360" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Capitulo 1</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" title="vimeo-player" src="https://player.vimeo.com/video/595545366?h=bf44df8e2d" width="640" height="360" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Capitulo 2</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" title="vimeo-player" src="https://player.vimeo.com/video/595545366?h=bf44df8e2d" width="640" height="360" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- Aside Right -->
  <?php include('includes/dashboard/aside-right.php'); ?>

  <!-- Footer Admin -->
  <?php include('includes/dashboard/footer-dashboard.php'); ?>

</div>

<script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script type="text/javascript" src="./node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script type="text/javascript" src="./node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./node_modules/vue/dist/vue.js"></script>
<script type="text/javascript" src="./node_modules/slick-carousel/slick/slick.js"></script>
<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
<script type="text/javascript" src="js/slick-home.js"></script>
<script type="text/javascript" src="js/nav/vue-nav.js"></script>

</body>
</html>
