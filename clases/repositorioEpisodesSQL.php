<?php

require_once("repositorioEpisodes.php");

class RepositorioEpisodesSQL extends repositorioEpisodes
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }
 
  public function getEpisodes()
  {

    try {

      // $sql = "SELECT * FROM episodes";
      $sql = "
        SELECT t1.*, t2.name AS name_unit, t2.description  AS desc_unit
        FROM episodes AS t1
        INNER JOIN units AS t2 ON t1.unit_id=t2.id;
      ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $episodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $episodes;
      
    } catch (Exception $e) {

      // lanzar error
      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

}

?>
