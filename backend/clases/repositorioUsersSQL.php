<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './../../vendor/autoload.php';

require_once("repositorioUsers.php");

class RepositorioUsersSQL extends repositorioUsers
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function login($email, $password)
  {

    try {

      $sql = "SELECT * FROM administrators WHERE email = '$email' ";
      // $sql = "
      //   SELECT t1.*, t2.*
      //   FROM users AS t1
      //   INNER JOIN challenges_loaded AS t2 ON t1.id=t2.user_id
      //   WHERE t2.approved = 0;
      // ";

      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (is_array($user)) { // Si existe el email en la base de datos

        if (password_verify( $password, $user['password']) ) {
          session_start();
          $_SESSION['user_backend'] = $user;
          unset($_SESSION['user_backend']['password']);
          unset($_SESSION['user_backend']['created_at']);
          return $_SESSION['user_backend'];
        }

      }
      
      return false;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");

    }

  }

  public function getUsers()
  {

    try {

      $sql = "
        SELECT t1.*, t2.name AS name_team_leader
        FROM users AS t1
        INNER JOIN team_leaders AS t2 ON t1.team_leader_id=t2.id;
      ";

      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

      unset($users['token']);
      unset($users['password']);

      return $users;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

}

?>
