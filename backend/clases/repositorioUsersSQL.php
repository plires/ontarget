<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__ . "./../../vendor/autoload.php";

require_once( __DIR__ . "/repositorioUsers.php" );

class RepositorioUsersSQL extends repositorioUsers
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function changeUnitsAuthorized($post)
  {

    $id = $post['id'];
    $newUnit = $post['unit'];
    $user_name = $post['user_name'];
    $user_email = $post['user_email'];
    $team_leader_name = $post['team_leader_name'];
    $team_leader_email = $post['team_leader_email'];

    $sql = "UPDATE users SET authorized_units = :authorized_units WHERE id = '$id' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":authorized_units", $newUnit, PDO::PARAM_INT);

    // Envio de email al usuario
    $template_user = file_get_contents('./../includes/emails/new-unit/new-unit-to-user.php');
    
    //configuro las variables a remplazar en el template
    $vars = array(
      '{user_name}',
      '{team_leader_name}',
      '{team_leader_email}',
      '{unit}', 
      '{path_dashboard}'
    );

    $values = array( 
      $user_name, 
      $team_leader_name, 
      $team_leader_email, 
      $newUnit, 
      BASE
    );

    //Remplazamos las variables por las marcas en los templates
    $template_user = str_replace($vars, $values, $template_user);

    // Enviar mail al usuario
    $this->sendmail(
      $team_leader_email, // Remitente 
      $team_leader_name, // Nombre Remitente 
      $team_leader_email, // Responder a:
      $team_leader_name, // Remitente al nombre: 
      $user_email, // Destinatario 
      $user_name, // Nombre del destinatario
      'Felicitaciones, aprobaste una nueva unidad', // Asunto 
      $template_user // Template usuario
    );
    return $stmt->execute();

  }

  public function updateCommentsPending($userId)
  {

    $sql = "UPDATE users SET pending_comments = :pending_comments WHERE id = '$userId' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":pending_comments", 0, PDO::PARAM_INT);
    return $stmt->execute();
    
  }

  public function updateChallengersPending($userId)
  {

    $sql = "UPDATE users SET pending_challengers = :pending_challengers WHERE id = '$userId' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":pending_challengers", 0, PDO::PARAM_INT);
    return $stmt->execute();
    
  }

  public function login($email, $password)
  {

    try {

      $sql = "SELECT * FROM team_leaders WHERE email = '$email' ";
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

  public function checkAuthUser() 
  {

    session_start();

    if ( !isset($_SESSION['user_backend']['id']) ) {
      session_destroy();
      return false;
    }

    $id = $_SESSION['user_backend']['id'];

    try {

      $sql = "SELECT * FROM team_leaders WHERE id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $admin = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($admin) {

        unset($admin['password']);
        unset($admin['created_at']);
        return $admin;

      } else {

        session_destroy();
        return false;

      }
      
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

  function sendmail($setFromEmail,$setFromName,$addReplyToEmail,$addReplyToName,$addAddressEmail,$addAddressName,$subject,$template)
  {

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    // Set PHPMailer to use the sendmail transport
    $mail->isSendmail();
    //Establecer desde donde será enviado el correo electronico
    $mail->setFrom($setFromEmail, $setFromName);
    //Establecer una direccion de correo electronico alternativa para responder
    $mail->addReplyTo($addReplyToEmail, $addReplyToName);
    //Establecer a quien será enviado el correo electronico
    $mail->addAddress($addAddressEmail, $addAddressName);
    //Establecer el asunto del mensaje
    $mail->Subject = $subject;
    //convertir HTML dentro del cuerpo del mensaje
    $mail->msgHTML($template);
      //send the message, check for errors
    if (!$mail->send()) {
      return false;
    } else {
      return true;
    }

  }

}

?>
