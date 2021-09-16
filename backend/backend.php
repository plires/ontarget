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
</head>
<body class="hold-transition sidebar-mini">

<div id="app" class="wrapper">

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
                        <table id="example1" class="table table-bordered table-striped">

                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Teléfono</th>
                              <th>Unidades Autorizadas</th>
                              <th>Fecha de Registro</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr v-for="(user, index) in users" :key="index">
                              <td v-cloak>{{ user.name }}</td>
                              <td v-cloak>{{ user.email }}</td>
                              <td v-cloak>{{ user.phone }}</td>
                              <td v-cloak>{{ user.authorized_units }}</td>
                              <td v-cloak>{{ user.created_at }}</td>
                              <td v-cloak>Acciones</td>
                            </tr>
                          </tbody>

                          <tfoot>
                            <tr>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Teléfono</th>
                              <th>Unidades Autorizadas</th>
                              <th>Fecha de Registro</th>
                              <th>Acciones</th>
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
<!-- AdminLTE App -->
<script src="./../node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="./../node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./../node_modules/vue/dist/vue.js"></script>
<script type="text/javascript" src="./js/backend.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>
