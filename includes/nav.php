<nav class="transition" id="nav">

  <div class="logo">
    <a href="./">
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

    <?php if ($current == 'blog'): ?>
      
      <li><a class="transition" href="./../quienes-somos.php">Quienes Somos</a></li>
      <li><a class="transition" href="./../aprender.php">¿Qué Aprenderemos?</a></li>
      <li><a class="transition" href="./../como-funciona.php">¿Cómo Funciona?</a></li>
      <li><a class="transition" href="./../blog">Blog</a></li>
      <li><a class="transition" href="./../faq.php">FAQ</a></li>
      <li><a class="transition" href="./../contactos.php">Contacto</a></li>

    <?php else: ?>

      <li><a class="transition" href="./quienes-somos.php">Quienes Somos</a></li>
      <li><a class="transition" href="./aprender.php">¿Qué Aprenderemos?</a></li>
      <li><a class="transition" href="./como-funciona.php">¿Cómo Funciona?</a></li>
      <li><a class="transition" href="./blog">Blog</a></li>
      <li><a class="transition" href="./faq.php">FAQ</a></li>
      <li><a class="transition" href="./contactos.php">Contacto</a></li>

    <?php endif ?>

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