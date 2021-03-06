<?php

require __DIR__ . '/../includes/config.inc.php';
require __DIR__ . '/repositorio.php';
require __DIR__ . '/repositorioUsersSQL.php';
require __DIR__ . '/repositorioEpisodesSQL.php';

class RepositorioSQL extends Repositorio {

  protected $conexion;

  /**
   * [__construct Establece la conexion con la base]
   */
  public function __construct() {

    try {
      $this->conexion = new PDO(DSN_APP, DB_USER_APP, DB_PASS_APP);
    } catch (Exception $e) {
      echo 'No se pudo conectar a la base de datos. Error: '. $e .' intente mas tarde...';
    }

    $this->repositorioUsers = new RepositorioUsersSQL($this->conexion);
    $this->repositorioEpisodes = new repositorioEpisodesSQL($this->conexion);

  }
}

?>
