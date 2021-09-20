<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './../../vendor/autoload.php';

require_once("repositorioChallenger.php");

class RepositorioChallengerSQL extends repositorioChallenger
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function getChallengers()
  {

    try {

      $sql = "SELECT * FROM challenges_loaded";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $challenges_loaded = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $challenges_loaded;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

  public function getChallengerByUser($id) 
  {

    try {

      $sql = "
        SELECT * FROM challenges_loaded 
        WHERE user_id = '$id' 
        AND approved = 0 
        ORDER BY created_at DESC
      ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $challenges_loaded = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($challenges_loaded as $key => $challenge) {
        $challenges_loaded[$key]['files'] = json_decode($challenge['files']);
      }

      return $challenges_loaded;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }
  
}

?>
