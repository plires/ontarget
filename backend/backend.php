<?php
  session_start();

  if ( !isset($_SESSION['user_backend']) ) {
    session_destroy();
    header('Location: ./');
  }
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>On Target | Dashboard</title>

  <!-- Favicons -->
  <?php include('./../includes/favicon.php'); ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="./css/app-backend.css">
</head>
<body class="hold-transition sidebar-mini">

<div id="app" class="dashboard wrapper">

  <!-- Msgs -->
  <?php include('./../includes/msg.php'); ?>

  <!-- Errors -->
  <?php include('./../includes/errors.php'); ?>

  <!-- Modal para Autorizar Unidades al Usuario -->
  <?php include('./includes/modal-authorized-units-user.php'); ?>

  <!-- Modal de datos de Usuario -->
  <?php include('./includes/modal-data-user.php'); ?>

  <!-- Modal de datos de Usuario -->
  <?php include('./includes/modal-challengers-user.php'); ?>

  <!-- Modal de comentarios sin leer del Usuario -->
  <?php include('./includes/modal-last-comments.php'); ?>

  <!-- Nav -->
  <?php include('./includes/nav.php'); ?>

  <!-- Sidebar -->
  <?php include('./includes/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-lg-12">

            <!-- Content Header (Page header) -->
            <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Usuarios</h1>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">

                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Usuarios asignados a vos</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <table id="tableUsers" class="table table-bordered table-striped">

                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Progreso</th>
                              <th class=" text-center">Unidades Autorizadas</th>
                              <th class=" text-center">Notificaciones</th>
                              <th class=" text-center">Acciones</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr v-for="(user, index) in usersFiltered" :key="index">
                              <td v-cloak>{{ user.id }}</td>
                              <td v-cloak>{{ user.name }}</td>
                              <td v-cloak>{{ user.email }}</td>
                              <td class="project_progress">
                                  <div class="progress progress-sm">
                                      <div 
                                        class="progress-bar bg-green" 
                                        role="progressbar" 
                                        :aria-valuenow="Math.round((user.authorized_units * 100) / totalUnits)" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100" 
                                        :style="'width: ' + Math.round((user.authorized_units * 100) / totalUnits) + '%'">
                                      </div>
                                  </div>
                                  <small>
                                      {{ Math.round((user.authorized_units * 100) / totalUnits) }}% Completo
                                  </small>
                              </td>
                              <td v-cloak class="text-center">{{ user.authorized_units }}</td>
                              <td class="cta" v-cloak>
                                <button
                                  :id="'btn_pending_comments_user_' + user.id"  
                                  v-if="user.pending_comments == 1"
                                  @click="getCommentsByUser(user.id)">
                                    <i class="fas fa-envelope transition"></i>
                                </button>
                                <button 
                                  :id="'btn_pending_challengers_user_' + user.id"  
                                  v-if="user.pending_challengers == 1"
                                  @click="getChallengerByUser(user.id)">
                                  <i class="fas fa-tasks transition"></i>
                                </button>
                              </td>
                              <td v-cloak class="text-center">

                                <div class="btn-group text-center">
                                  <button type="button" class="acciones btn">Acciones</button>
                                  <button type="button" class="acciones btn dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <div class="dropdown-menu" role="menu" style="">
                                    <button @click="getChallengerByUser(user.id)" class="dropdown-item">Ver Entregas Realizadas</button>
                                    <button @click="getCommentsByUser(user.id)" class="dropdown-item">Ver Comentarios Enviados</button>
                                    <button @click="viewUserData(user.id)" class="dropdown-item">Ver Datos del Usuario</button>
                                    <div class="dropdown-divider"></div>
                                    <button @click="openModalUnitsAuthorized(user.id)" class="dropdown-item">Cambiar Unidades Autorizadas</button>
                                  </div>
                                </div>
                                
                              </td>
                            </tr>
                          </tbody>

                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Progreso</th>
                              <th class=" text-center">Unidades Autorizadas</th>
                              <th class=" text-center">Notificaciones</th>
                              <th class=" text-center">Acciones</th>
                            </tr>
                          </tfoot>

                        </table>
                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </section>
            
          </div>


        </div>
        
      </div>
    </div>
    
  </div>

  <!-- Sidebar -->
  <?php include('./includes/sidebar-right.php'); ?>

  <!-- Footer -->
  <?php include('./includes/footer.php'); ?>
  
</div>

<!-- jQuery -->
<script src="./../node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./../node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./../node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/jszip/jszip.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Moment -->
<script src="./../node_modules/moment/moment.js"></script>
<script src="./../node_modules/moment/locale/es.js"></script>
<!-- AdminLTE App -->
<script src="./../node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="./../node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./../node_modules/vue/dist/vue.js"></script>
<script type="text/javascript" src="./js/backend.js"></script>

</body>
</html>
