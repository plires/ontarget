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
  <title>On Target | Historial Desafíos</title>

  <!-- Favicons -->
  <?php include('./../includes/favicon.php'); ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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

  <div id="loading" class="lds-ring"><div></div><div></div><div></div><div></div></div>

  <!-- Msgs -->
  <?php include('./../includes/msg.php'); ?>

  <!-- Errors -->
  <?php include('./../includes/errors.php'); ?>

  <!-- Challlenge User -->
  <?php include('./includes/modal-one-challenge.php'); ?>

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
                    <h1>Historial de Desafíos Entregados por Usuario</h1>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">

                    <div class="text-center">
                      <div class="form-group">
                        <label>Seleccioná el Usuario</label>

                        <select onchange="app.viewChallengerHistoryByUser(event.target.value)" class="form-control select2">
                          <option value="0">Todos los usuarios</option>
                          <option v-for="user in usersFiltered" :value="user.id" :key="user.id">{{ user.name }}</option>
                        </select>
                       
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Desafíos Entregados</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">

                        <table id="tableChallengers" class="table table-bordered table-striped">

                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Enviado Por: </th>
                              <th>Fecha</th>
                              <th>Hora</th>
                            </tr>
                          </thead>

                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Enviado Por: </th>
                              <th>Fecha</th>
                              <th>Hora</th>
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

  <!-- Footer -->
  <?php include('./includes/footer.php'); ?>
  
</div>

<!-- jQuery -->
<script src="./../node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./../node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="./../node_modules/admin-lte/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./../node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<!-- Moment -->
<script src="./../node_modules/moment/moment.js"></script>
<script src="./../node_modules/moment/locale/es.js"></script>
<!-- AdminLTE App -->
<script src="./../node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="./../node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./../node_modules/vue/dist/vue.js"></script>
<script type="text/javascript" src="./js/challengers.js"></script>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>


</body>
</html>
