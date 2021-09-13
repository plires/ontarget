<?php

require_once("repositorioUsers.php");
require_once("app.php");

class RepositorioUsersSQL extends repositorioUsers
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
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

      if (password_verify( $password, $user['password']) && $user['token'] == NULL ) {
        session_start();
        $_SESSION['user'] = $user;
        unset($_SESSION['user']['password']);
        unset($_SESSION['user']['token']);
        unset($_SESSION['user']['created_at']);
        return $_SESSION['user'];
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

    $sql = "SELECT * FROM users WHERE email = '$email' ";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($email == $user['email'] && $token == $user['token']) {

      // Eliminamos el token del usuario y ya queda habilitado para el ingreso
      $sql = "UPDATE users SET token = :token WHERE email = '$email' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->bindValue(":token", NULL, PDO::PARAM_STR);
      $stmt->execute();

      return $user;
      
    }

    return false;
    
  }

  public function assignNewTeamLeader() {

    $sql = "SELECT team_leader_id FROM users ORDER BY id DESC LIMIT 1";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $next_team_leader = (int)$user['team_leader_id'] + 1;

    $sql = "SELECT * FROM team_leaders WHERE id = '$next_team_leader' ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $next_team_leader = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$next_team_leader) {
      $team_leader = 1;
    } else {
      $team_leader = (int)$next_team_leader['id'];
    }

    return $team_leader;    

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

      // Insertar en base de datos
      $sql = "
        INSERT INTO users 
        values(default, :name, :email, :phone, :password, :token, :team_leader_id, :authorized_units, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
      $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
      $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
      $stmt->bindValue(":password", $password_hash, PDO::PARAM_STR);
      $stmt->bindValue(":token", $token, PDO::PARAM_STR);
      $stmt->bindValue(":team_leader_id", $team_leader, PDO::PARAM_INT);
      $stmt->bindValue(":authorized_units", 1, PDO::PARAM_STR);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();

      $app = new App;

      // Enviar email al usuario con el token para que confirme su email
      // $sendUser = $app->sendEmail('Usuario', 'Contacto Usuario', $post);
      
      // Enviar un email para avisar al team leader asignado que tiene un nuevo lacayo 

      return $register;
      
    } catch (Exception $e) {
      
      header("HTTP/1.1 500 Internal Server Error");

    }

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
    
    $stmt->bindValue(":user_id", $user['id'], PDO::PARAM_STR);
    $stmt->bindValue(":selector", $selector, PDO::PARAM_STR);
    $stmt->bindValue(":token", hash('sha256', bin2hex($token)), PDO::PARAM_STR);
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
      session_start();
      $_SESSION['logged'] = true;
    } else {
      header('Location: ./');
    }

    return $results[0]['user_id'];

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

      // Emviar email con el link al usuario
      $app = new App;
      // $sendUser = $app->sendEmail('Usuario', 'Contacto Usuario', $post);
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

  // public function setValuesUser($data)
  // {

  //   $id = (int)$data['id_user'];

  //   $sql = "UPDATE users SET user = :user, email = :email WHERE id = '$id' ";

  //   $stmt = $this->conexion->prepare($sql);

  //   $stmt->bindValue(":user", $data['user'], PDO::PARAM_STR);
  //   $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);

  //   return $stmt->execute();

  // }

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

  public function saveCommentsToTeamLeader($user, $team_leader, $comment) {
    
    $date = date("Y-m-d H:i:s");

    try {
      
      $sql = "
        INSERT INTO comments 
        values(default, :user_id, :comment, :team_leader_id, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":user_id", $user, PDO::PARAM_STR);
      $stmt->bindValue(":comment", $comment, PDO::PARAM_STR);
      $stmt->bindValue(":team_leader_id", $team_leader, PDO::PARAM_STR);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();

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

        $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, password = :password WHERE id = '$id' ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
        $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);
        $stmt->bindValue(":password", $password_hash, PDO::PARAM_STR);

        $user_edit = $stmt->execute();

        return $user_edit;
        
      } else {

        $sql = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = '$id' ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":name", $post['name'], PDO::PARAM_STR);
        $stmt->bindValue(":email", $post['email'], PDO::PARAM_STR);
        $stmt->bindValue(":phone", $post['phone'], PDO::PARAM_STR);

        $user_edit = $stmt->execute();

        return $user_edit;

      }
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error");
      
    }
    
  }

}

?>
