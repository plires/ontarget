<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__ . './../vendor/autoload.php';

require_once( __DIR__ . "/repositorioUsers.php" );

class RepositorioUsersSQL extends repositorioUsers
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function updateCommentsPending($userId)
  {

    $sql = "UPDATE users SET pending_comments = :pending_comments WHERE id = '$userId' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":pending_comments", 1, PDO::PARAM_INT);
    return $stmt->execute();
    
  }

  public function updateChallengersPending($userId)
  {

    $sql = "UPDATE users SET pending_challengers = :pending_challengers WHERE id = '$userId' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":pending_challengers", 1, PDO::PARAM_INT);
    return $stmt->execute();
    
  }

  public function sendContact($post) {

    $newsletter = 0;

    if ($post['newsletter'] === 'true') {
      $newsletter = 1;
    }

    $date = date("Y-m-d H:i:s");

    try {
      
      $sql = "
        INSERT INTO contacts_form 
        values(default, :name, :lastname, :email, :phone, :comments, :newsletter, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
      $stmt->bindValue(":lastname", $post['lastname'], PDO::PARAM_STR);
      $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
      $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
      $stmt->bindValue(":comments", $post['comments'], PDO::PARAM_STR);
      $stmt->bindValue(":newsletter", $newsletter, PDO::PARAM_STR);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();

      $template_user = file_get_contents('./../includes/emails/contacts/contact-to-user.php');
      $template_client = file_get_contents('./../includes/emails/contacts/contact-to-client.php');
      
      //configuro las variables a remplazar en el template
      $vars = array(
        '{name}',
        '{lastname}',
        '{email}',
        '{phone}',
        '{comment}',
        '{path_backend}'
      );

      $values = array( 
        $post['name'],
        $post['lastname'],
        $post['email'],
        $post['phone'],
        $post['comments'],
        PATH_BACKEND 
      );

      //Remplazamos las variables por las marcas en los templates
      $template_user = str_replace($vars, $values, $template_user);
      $template_client = str_replace($vars, $values, $template_client);

      // Enviar mail al usuario
      $this->sendmail(
        EMAIL_ONTARGET, // Remitente 
        NAME_ONTARGET, // Nombre Remitente 
        EMAIL_ONTARGET, // Responder a:
        NAME_ONTARGET, // Remitente al nombre: 
        $post['email'], // Destinatario 
        $post['name'], // Nombre del destinatario
        'Gracias por tu contacto', // Asunto 
        $template_user // Template usuario
      );

      // Enviar mail al cliente
      $send_to_client = 
      $this->sendmail(
        $post['email'], // Remitente 
        $post['name'], // Nombre Remitente 
        $post['email'], // Responder a:
        $post['name'], // Remitente al nombre: 
        EMAIL_ONTARGET, // Destinatario 
        NAME_ONTARGET, // Nombre del destinatario
        'Nuevo mensaje desde el formulario de contacto web', // Asunto 
        $template_client // Template cliente
      );
      
      return $send_to_client;

    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");
      
    }

  }

  function sendmail($setFromEmail,$setFromName,$addReplyToEmail,$addReplyToName,$addAddressEmail,$addAddressName,$subject,$template){

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    
    if (ENVIRONMENT === 'local') {

      $mail->isSendmail();

    } else {

      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      // $mail->SMTPDebug = 4;
      $mail->isSMTP();
      $mail->Host       = SMTP;
      $mail->SMTPAuth   = true; 
      $mail->Username   = USERNAME; 
      $mail->Password   = PASSWORD; 
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
      $mail->Port       = EMAIL_PORT;
      $mail->CharSet    = EMAIL_CHARSET;
      $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
          )
      );

    }

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

  public function checkAuthUser() {

    session_start();

    if ( !isset($_SESSION['user']['id']) ) {
      session_destroy();
      return false;
    }

    $id = $_SESSION['user']['id'];

    try {

      $sql = "SELECT * FROM users WHERE id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        unset($user['password']);
        unset($user['token']);
        unset($user['created_at']);
        return $user;
      } else {
        session_destroy();
        return false;
      }
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");
      
    }

  }

  public function login($email, $password)
  {

    try {

      $sql = "SELECT * FROM users WHERE email = '$email' ";

      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (is_array($user)) { // Si existe el email en la base de datos

        if (password_verify( $password, $user['password']) && $user['token'] == NULL ) {
          session_start();
          $_SESSION['user'] = $user;
          unset($_SESSION['user']['password']);
          unset($_SESSION['user']['token']);
          unset($_SESSION['user']['created_at']);
          return $_SESSION['user'];
        }

      }
      
      return false;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");

    }

  }

  public function verifyduplicateEmail($email) {

    $sql = "SELECT * FROM users";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $email_in_bdd = array_filter($users, function ($var) use ($email) {
      return ($var['email'] == $email);
    });

    if ($email_in_bdd) {
      return true;
    } 

    return false;

  }

  public function verifyTokenNewEmail($email, $token) {

    $sql = "
      SELECT users.*, team_leaders.name AS team_leader_name, team_leaders.email AS team_leader_email
      FROM users, team_leaders
      WHERE users.email = '$email'
      AND users.team_leader_id = team_leaders.id
    ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($email == $user['email'] && $token == $user['token']) {

      // Eliminamos el token del usuario y ya queda habilitado para el ingreso
      $sql = "UPDATE users SET token = :token WHERE email = '$email' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->bindValue(":token", NULL, PDO::PARAM_STR);
      $stmt->execute();

      // Enviar email al Team Leader con informando que el usuario valido su casilla de email
      $template_client = file_get_contents('./includes/emails/register/register-to-client.php');
      
      //configuro las variables a remplazar en el template
      $vars = array(
        '{name}',
        '{email}',
        '{phone}',
        '{city}',
        '{team_leader_name}',
        '{team_leader_email}',
        '{path_backend}'
      );

      $values = array( 
        $user['name'],
        $user['email'],
        $user['phone'],
        $user['city'],
        $user['team_leader_name'],
        $user['team_leader_email'],
        PATH_BACKEND 
      );

      //Remplazamos las variables por las marcas en los templates
      $template_client = str_replace($vars, $values, $template_client);

      $this->sendmail(
        $user['email'], // Remitente 
        $user['name'], // Nombre Remitente 
        $user['email'], // Responder a:
        $user['name'], // Remitente al nombre: 
        $user['team_leader_email'], // Destinatario 
        $user['team_leader_name'], // Nombre del destinatario
        'Tenes un nuevo usuario asignado.', // Asunto 
        $template_client // Template usuario
      );

      return $user;
      
    }

    return false;
    
  }

  public function assignNewTeamLeader() {

    $sql = "SELECT team_leader_id FROM users ORDER BY id DESC LIMIT 1";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM team_leaders WHERE role = 'Team Leader' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $team_leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($user) {
      foreach ($team_leaders as $team_leader) {
          
        if ( $team_leader['id'] > $user['team_leader_id'] ) {
          return $team_leader;
        }

      }
    }


    $sql = "SELECT * FROM team_leaders WHERE role = 'Team Leader' ORDER BY id ASC LIMIT 1";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  }

  public function register($post)
  {

    $email = $post['email'];

    try {

      // Verificar que el email no se encuentre registrado
      $email_in_bdd = $this->verifyduplicateEmail($email);

      if ($email_in_bdd) {
        $result['email_duplicado'] = true;
        $result['email_duplicado_msg'] = 'El correo ya se encuentra registrado';
        return $result;
      }

      $password_hash = password_hash($post['password'], PASSWORD_DEFAULT);
      $token = bin2hex(random_bytes(32));

      $urlToEmail = BASE .'verify.php?' .http_build_query([
        'token' => $token,
        'email' => $email
      ]);

      // Asignar al teamLeader
      $team_leader = $this->assignNewTeamLeader();

      $date = date("Y-m-d H:i:s");

      // Alta en Perfit
      $this->updateEmailInPerfit($post, $token, $team_leader, 0, 1);

      // Insertar en base de datos
      $sql = "
        INSERT INTO users 
        values(default, :name, :email, :phone, :city, :password, :token, :team_leader_id, :authorized_units, :pending_challengers, :pending_comments, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
      $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
      $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
      $stmt->bindValue(":city", $post['city'], PDO::PARAM_STR);
      $stmt->bindValue(":password", $password_hash, PDO::PARAM_STR);
      $stmt->bindValue(":token", $token, PDO::PARAM_STR);
      $stmt->bindValue(":team_leader_id", $team_leader['id'], PDO::PARAM_INT);
      $stmt->bindValue(":authorized_units", 1, PDO::PARAM_STR);
      $stmt->bindValue(":pending_challengers", 0, PDO::PARAM_INT);
      $stmt->bindValue(":pending_comments", 0, PDO::PARAM_INT);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();

      $template_user = file_get_contents('./../includes/emails/register/register-to-user.php');
      
      //configuro las variables a remplazar en el template
      $vars = array(
        '{name}',
        '{email}',
        '{phone}',
        '{city}',
        '{url}',
        '{team_leader_name}',
        '{team_leader_email}',
        '{path_backend}'
      );

      $values = array( 
        $post['name'],
        $post['email'],
        $post['phone'],
        $post['city'],
        $urlToEmail,
        $team_leader['name'],
        $team_leader['email'],
        PATH_BACKEND 
      );

      //Remplazamos las variables por las marcas en los templates
      $template_user = str_replace($vars, $values, $template_user);

      // Enviar mail al usuario
      $this->sendmail(
        $team_leader['email'], // Remitente 
        $team_leader['name'], // Nombre Remitente 
        $team_leader['email'], // Responder a:
        $team_leader['name'], // Remitente al nombre: 
        $post['email'], // Destinatario 
        $post['name'], // Nombre del destinatario
        'Registro Exitoso!', // Asunto 
        $template_user // Template usuario
      );

      // Registrar en Perfit

      return $register;
      
    } catch (Exception $e) {
      
      header("HTTP/1.1 500 Internal Server Error");

    }

  }

  public function updateEmailInPerfit($post, $token, $team_leader, $verified_user, $authorizedUnits) {

    $date = date("Y-m-d");
    
    $perfit = new PerfitSDK\Perfit( ['apiKey' => PERFIT_APY_KEY ] );

    $response = $perfit->post('/lists/' .PERFIT_LIST. '/contacts', 
      [
        'firstName' => $post['name'], 
        'email' => $post['email'],
        'customFields' => 
          [
            [
              'id' => 14, 
              'value' => $post['phone']
            ],
            [
              'id' => 15, 
              'value' => $post['city']
            ],
            [
              'id' => 16, 
              'value' => $token
            ],
            [
              'id' => 17, 
              'value' => $verified_user
            ],
            [
              'id' => 15, 
              'value' => $post['city']
            ],
            [
              'id' => 18, 
              'value' => $team_leader['id']
            ],
            [
              'id' => 19, 
              'value' => $team_leader['name']
            ],
            [
              'id' => 20, 
              'value' => $team_leader['email']
            ],
            [
              'id' => 21, 
              'value' => $authorizedUnits
            ],
            [
              'id' => 22, 
              'value' => $date
            ]
          ]
      ]
    );

    return $response;

  }

  public function generateTokenAndSaveInDatabase($user) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $urlToEmail = BASE .'reset.php?' .http_build_query([
        'selector' => $selector,
        'id' => $user['id'],
        'validator' => bin2hex($token)
    ]);

    $expires = new DateTime('NOW');
    $expires->add(new DateInterval('PT01H')); // 1 hour

    // Insertar en base de datos
    $sql = "
      INSERT INTO account_recovery (user_id, selector, token, expires) 
      VALUES (:user_id, :selector, :token, :expires);
    ";

    $stmt = $this->conexion->prepare($sql);
    
    $stmt->bindValue(":user_id", $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(":selector", $selector, PDO::PARAM_STR);
    $stmt->bindValue(":token", bin2hex($token), PDO::PARAM_STR);
    $stmt->bindValue(":expires", $expires->format('Y-m-d\TH:i:s'), PDO::PARAM_STR);

    $generatedToken['executed'] = $stmt->execute();
    $generatedToken['urlToEmail'] = $urlToEmail;

    return $generatedToken;

  }

  public function newPass($post) {

    $password_hash = password_hash($post['password_reset'], PASSWORD_DEFAULT);

    $id = (int)$post['user_id'];

    $sql = "UPDATE users SET password = :password WHERE id = '$id' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindValue(":password", $password_hash, PDO::PARAM_STR);

    $set_new_pass = $stmt->execute();

    if ($set_new_pass) {
      //borrar de la tabla account_recovery al usuario
      $sql = "DELETE FROM account_recovery WHERE user_id='$id'";
      $stmt = $this->conexion->prepare($sql);
      return $stmt->execute();
    }

  }

  public function resetPassword($selector, $validator, $user_id) {

    $sql = "SELECT * FROM account_recovery WHERE selector = ? AND expires >= NOW()";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$selector]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results) && hash_equals($validator, $results[0]['token']) && $results[0]['user_id'] == $user_id ) {
      return $results[0]['user_id'];
      // session_start();
      // $_SESSION['logged'] = true;
    } else {
      header('Location: ./');
    }

  }

  public function forgotPassword($post)
  {

    try {

      // Verificar que el email exista
      $user = $this->getUserByEmail($post['email']);

      // Devolver mensaje de error si es asi
      if (!$user) {
        $result['email_inexistente'] = true;
        $result['email_inexistente_msg'] = 'Este correo no esta registrado. Ingrese el correo con el cual se registró';
        return $result;
      }

      // Generar un token, guardarlo en la base de datos
      $generatedToken = $this->generateTokenAndSaveInDatabase($user);

      if ($generatedToken['executed']) {

        $template_user = file_get_contents('./../includes/emails/reset-password/reset-password-to-user.php');

        //configuro las variables a remplazar en el template
        $vars = array('{email}' , '{url}');
        $values = array( $post['email'], $generatedToken['urlToEmail'] );

        //Remplazamos las variables por las marcas en los templates
        $template_user = str_replace($vars, $values, $template_user);

        // Enviar mail al usuario
        $this->sendmail(
          EMAIL_ONTARGET, // Remitente 
          NAME_ONTARGET, // Nombre Remitente 
          EMAIL_ONTARGET, // Responder a:
          NAME_ONTARGET, // Remitente al nombre: 
          $post['email'], // Destinatario 
          $post['email'], // Nombre del destinatario
          'Reseteo de password', // Asunto 
          $template_user // Template usuario
        );

      }

      return true;
     
    } catch (Exception $e) {
      
      header("HTTP/1.1 500 Internal Server Error");

    }

  }

  public function getUserById($id)
  {
    $sql = "SELECT * FROM users WHERE id = '$id' ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;

  }

  public function getTeamLeaderById($id)
  {
    $sql = "SELECT * FROM team_leaders WHERE id = '$id' ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $team_leader = $stmt->fetch(PDO::FETCH_ASSOC);

    return $team_leader;

  }

  public function getUserByEmail($email)
  {

    $sql = "
      SELECT * 
      FROM users
      WHERE email = '$email'
    ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;

  }

  public function saveCommentsToTeamLeader($post)
  {

    $user = $post['user_id'];
    $user_name = $post['user_name'];
    $user_email = $post['user_email'];
    $user_phone = $post['user_phone'];
    $user_city = $post['user_city'];
    $team_leader = $post['team_leader_id'];
    $team_leader_name = $post['team_leader_name'];
    $team_leader_email = $post['team_leader_email'];
    $comment = $post['comment'];
    
    $date = date("Y-m-d H:i:s");

    try {
      
      $sql = "
        INSERT INTO comments 
        values(default, :user_id, :comment, :team_leader_id, :unread, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":user_id", $user, PDO::PARAM_STR);
      $stmt->bindValue(":comment", $comment, PDO::PARAM_STR);
      $stmt->bindValue(":team_leader_id", $team_leader, PDO::PARAM_STR);
      $stmt->bindValue(":unread", 1, PDO::PARAM_INT);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();


      // Editar el campo de comentarios pendientes en la tabla users
      $this->updateCommentsPending($user);

      // Enviar email al team Leader
      $template_client = file_get_contents('./../includes/emails/msg-to-team-leader/msg-to-team-leader.php');

      //configuro las variables a remplazar en el template
      $vars = array(
        '{user_name}' ,
        '{user_email}' ,
        '{user_phone}' ,
        '{user_city}' ,
        '{team_leader_name}' ,
        '{team_leader_email}' ,
        '{comment}', 
        '{path_backend}', 
      );

      $values = array( 
        $user_name, 
        $user_email, 
        $user_phone, 
        $user_city, 
        $team_leader_name, 
        $team_leader_email, 
        $comment, 
        PATH_BACKEND
      );

      //Remplazamos las variables por las marcas en los templates
      $template_client = str_replace($vars, $values, $template_client);

      // Enviar mail al usuario
      $this->sendmail(
        $user_email, // Remitente 
        $user_name, // Nombre Remitente 
        $user_email, // Responder a:
        $user_name, // Remitente al nombre: 
        $team_leader_email, // Destinatario 
        $team_leader_name, // Nombre del destinatario
        'Contacto de un usuario asignado a vos', // Asunto 
        $template_client // Template usuario
      );
      
      return $register;

    } catch (Exception $e) {
      header("HTTP/1.1 500 Internal Server Error");
    }

  }

  public function userEdit($post) {

    $id = $post['user_id'];

    try {

      if ($post['mode_user_edit'] == 'true') {
      
        $password_hash = password_hash($post['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, city = :city, password = :password WHERE id = '$id' ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
        $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
        $stmt->bindValue(":city", $post['city'], PDO::PARAM_STR);
        $stmt->bindValue(":password", $password_hash, PDO::PARAM_STR);

        $user_edit = $stmt->execute();

        return $user_edit;
        
      } else {

        $sql = "UPDATE users SET name = :name, email = :email, phone = :phone , city = :city WHERE id = '$id' ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
        $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
        $stmt->bindValue(":city", $post['city'], PDO::PARAM_STR);

        $user_edit = $stmt->execute();

        return $user_edit;

      }
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");
      
    }
    
  }

  public function userBaja($post) {

    $id = $post['user_id'];

    try {

      // Elimino los comentarios de este usuario (tabla challenges_loaded)
      $sql = "DELETE FROM challenges_loaded WHERE user_id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $foo = $stmt->execute();

      // Elimino los desafios de este usuario (tabla comments)
      $sql = "DELETE FROM comments WHERE user_id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();

      // Elimino a este usuario (tabla users)
      $sql = "DELETE FROM users WHERE id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $user_baja = $stmt->execute();

      return $user_baja;

    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");
      
    }
    
  }

}

?>
