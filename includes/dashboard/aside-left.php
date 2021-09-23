<aside id="mainSidebar" class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a target="_blank" rel="noopener noreferrer" href="./" class="brand-link">
    <img src="../../img/dashboard/logo-carga.png" alt="ontarget Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    
    <span class="brand-text font-weight-light"><img src="../../img/dashboard/logo-ontarget.png" alt="on target Logo" class="img-fluid" style="opacity: .8"></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 mb-3 d-flex">
      <div @click="openModalPerfilUsuario" class="image">
        <i class="fas fa-user"></i>
      </div>
      <div class="info">
        <button @click="openModalPerfilUsuario" class="d-block" v-cloak>{{ authUser.name }}</button>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
             
        <li 
          v-if="authUser" 
          v-for="(unit, index) in units" 
          :key="index" 
          :class="['nav-item', unit[0].unit_id == currentUnit ? 'menu-open current' : '']">
          <a 
            href="#" 
            :class="['nav-link active', index <= authUser.authorized_units ? '' : 'unidad_deshabilitada']">
            <i class="nav-icon fas fa-video"></i>
            <p>
              {{ unit[0].name_unit }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li v-for="(episode, index_unit) in unit" :key="index_unit" class="nav-item">
              <a 
                v-if="authUser.authorized_units >= episode.unit_id" 
                @click="setCurrentUnit(unit[0].unit_id)" 
                href="./ver-unidad.php" 
                class="nav-link transition"
              >
                <i class="far fa-circle nav-icon transition"></i>
                <p>{{ episode.name }}</p>
              </a>

              <p class="inhabilitado nav-link" v-else>
                <i class="fas fa-ban nav-icon"></i>{{ episode.name }}
              </p>


            </li>
          </ul>

        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>