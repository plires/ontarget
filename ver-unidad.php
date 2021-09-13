<?php
  session_start();

  if ( !isset($_SESSION['user']) ) {
    session_destroy();
    header('Location: ./');
  }

  $current = 'primera';

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Primera Unidad | OnTarget</title>

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

<div id="app" class="unidades">

  <div class="wrapper">

    <!-- Login -->
    <?php include('includes/login.php'); ?>

    <!-- Modal Challenge -->
    <?php include('includes/modal-challenges.php'); ?>

    <!-- Modal Perfil Usuario -->
    <?php include('includes/modal-perfil.php'); ?>

    <!-- Modal Contactar a tu Team Leader -->
    <?php include('includes/modal-contact-team-leader.php'); ?>

    <!-- Modal Upload Challenge -->
    <?php include('includes/modal-upload.php'); ?>
    
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
    <div class="content-wrapper">
      
      <!-- Progress Global -->
      <div class="content-header progreso">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Progreso Global en el Método Ontarget</h1>

              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :aria-valuenow="percentComplete" aria-valuemin="0" aria-valuemax="100" :style="'width: ' + percentComplete + '%'"></div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- Progress Global end -->
     
      <!-- Main content -->
      <div class="content">
        <div class="container">

          <!-- Header unidad -->
          <div class="row header_unidad_actual">

            <div class="col-sm-12 col-md-6">
              <h2>{{ unitData.name }}</h2>
              <p class="description">{{ unitData.description }}</p>
            </div>

            <div class="col-sm-12 col-md-6">
              <img
                v-if="unitData.image" 
                class="img-fluid" 
                :src="'img/dashboard/unidades/' + unitData.image" 
                :alt="unitData.name + '-' + unitData.id"
              >
              <img v-else class="img-fluid" src="img/no-image.gif" :alt="unitData.name + '-' + unitData.id">
            </div>

          </div>
          <!-- Header unidad end -->

          <!-- Episodios -->
          <div class="row content_capitulo">

            <div v-for="(episode, index) in filterEpisodesByUnit" :key="episode.id" class="col-lg-6">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">{{ episode.name }}</h3>
                  <p>{{ episode.description }}</p>
                </div>
                <div class="card-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" title="vimeo-player" :src="episode.url_video" frameborder="0" allowfullscreen></iframe>
                  </div>

                  <div v-if="parseInt(episode.challenge)" class="text-center">
                    <button 
                      class="btn btn-desafio transition"
                      @click="openModalChallenge(episode.unit_id, episode.number)">
                        Completá el desafío del capítulo {{ episode.unit_id }}
                    </button>
                  </div>

                </div>
              </div>
            </div>

          </div>
          <!-- Episodios end -->

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
<script type="text/javascript" src="./node_modules/vue/dist/vue.js"></script>
<script type="text/javascript" src="js/nav/vue-nav.js"></script>
<script type="text/javascript" src="./node_modules/aos/dist/aos.js"></script>
<script type="text/javascript" src="js/app.js"></script>

</body>
</html>
