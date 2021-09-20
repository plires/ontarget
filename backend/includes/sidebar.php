<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="./img/dashboard/ontarget-admin.png" alt="On Target logo" class="brand-image img-circle elevation-3 img-fluid" style="opacity: .8">
    <span class="brand-text font-weight-light">
      <img src="./img/dashboard/ontarget-frase.png" alt="On Target frase" class="img-fluid" style="opacity: .8">
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item exit_user">
          <a href="./php/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p v-cloak>{{ authUser.name }}</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="backend.php" class="nav-link">
            <i class="nav-icon fas fa-sliders-h"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="backend.php" class="nav-link">
            <i class="nav-icon fas fa-comments"></i>
            <p>Comentarios Historial</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="backend.php" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>Desafíos Historial</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>