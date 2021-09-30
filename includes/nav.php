<nav class="transition" id="nav">

  <div class="logo">
    <a href="<?= BASE ?>">
      <img class="img-fluid image_no_shadow_rounded" src="#" alt="logo ontarget">
    </a>
    <div class="menu_mobile">

      <button v-if="Object.keys(authUser).length === 0" @click="openPopUpLogin" class="transition">
        <i class="fas fa-unlock-alt transition"></i>
      </button>

      <button v-else class="transition" @click="openPopUpAcount">
        <i class="far fa-user-circle transition"></i>
      </button>      

      <button><i class="fas fa-bars toggle"></i></button>
    </div>
  </div>

  <ul class="navigation transition">

      <li><a class="transition" href="<?= BASE ?>quienes-somos.php">Quienes Somos</a></li>
      <li><a class="transition" href="<?= BASE ?>aprender.php">¿Qué Aprenderemos?</a></li>
      <li><a class="transition" href="<?= BASE ?>como-funciona.php">¿Cómo Funciona?</a></li>
      <li><a class="transition" href="<?= BASE ?>blog">Blog</a></li>
      <li><a class="transition" href="<?= BASE ?>faq.php">FAQ</a></li>
      <li><a class="transition" href="<?= BASE ?>contactos.php">Contacto</a></li>

    <li v-if="Object.keys(authUser).length === 0">
      <button @click="openPopUpLogin" class="transition">
        <i class="fas fa-unlock-alt transition"></i>
      </button>
    </li>

    <li v-else>
      <button @click="openPopUpAcount" class="transition">
        <i class="far fa-user-circle transition"></i>
      </button>      
    </li>

  </ul>
  
</nav>