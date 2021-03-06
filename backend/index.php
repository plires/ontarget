<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - On Target</title>

  <!-- Favicons -->
  <?php include('./../includes/favicon.php'); ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./../node_modules/admin-lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="./css/app-backend.css">
</head>

<body class="hold-transition login-page">

<div id="app" class="login-box">

  <!-- Errores -->
  <?php include('includes/errors.php'); ?>

  <!-- Msg -->
  <?php include('includes/msg.php'); ?>

  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img class="img-fluid" src="img/login/logo-ontarget-backend.png" alt="logo ontarget">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Regístrese para iniciar su sesión</p>

      <form method="post">

        <!-- Email -->
        <div class="input-group mb-3">
          <input 
            type="email" 
            class="form-control" 
            placeholder="Email" 
            v-model="email_login" 
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- Email end -->

        <!-- Password -->
        <div class="input-group mb-3">
          <input 
            type="password" 
            class="form-control" 
            placeholder="Password" 
            v-model="password_login"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Password end -->

        <!-- Recordar -->
        <div class="row">
          <div class="col-12">
            <button @click.prevent="login" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
        <!-- Recordar end -->

      </form>

      <p class="mb-1 mt-3">
        <a href="forgot-password.php">Olvide mi password</a>
      </p>
    </div>
    
  </div>

</div>

<!-- jQuery -->
<script src="./../node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./../node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./../node_modules/admin-lte/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="./../node_modules/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="./../node_modules/vue/dist/vue.min.js"></script>
<script type="text/javascript" src="./js/login.js"></script>
</body>
</html>
