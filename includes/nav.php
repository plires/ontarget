<nav class="transition" id="nav">

  <div class="logo">
    <a href="./">
      <img class="img-fluid image_no_shadow_rounded" src="#" alt="logo ontarget">
    </a>
    <div class="menu_mobile">
      <button @click="openPopUpLogin"><i class="far fa-user-circle transition"></i></button>
      <button><i class="fas fa-bars toggle"></i></button>
    </div>
  </div>

  <ul class="navigation transition">
    <li><a class="transition" href="quienes-somos.php">Quienes Somos</a></li>
    <li><a class="transition" href="aprender.php">¿Qué Aprenderemos?</a></li>
    <li><a class="transition" href="como-funciona.php">¿Cómo Funciona?</a></li>
    <li><a class="transition" href="#">Blog</a></li>
    <li><a class="transition" href="faq.php">FAQ</a></li>
    <li><a class="transition" href="contactos.php">Contacto</a></li>
    <li><button @click="openPopUpLogin" class="transition" href="#"><i class="far fa-user-circle transition"></i></button></li>
  </ul>
  
</nav>