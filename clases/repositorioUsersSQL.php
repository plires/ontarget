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

  public function login($email, $password)
  {

    try {

      $sql = "SELECT * FROM users WHERE email = '$email' ";

      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        return false;
      }

      if (password_verify( $password, $user['password']) ) {
        return $user;
      }

      return false;
      
    } catch (Exception $e) {

      // lanzar error
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
      $token = md5($post['password']);

      // Traer el proximo teamleader
      // $sql = "SELECT * FROM team_leaders ORDER BY id ASC";
      // $stmt = $this->conexion->prepare($sql);
      // $stmt->execute();
      // $team_leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // $sql = "SELECT * FROM users";
      // $stmt = $this->conexion->prepare($sql);
      // $stmt->execute();
      // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // $id = $this->conexion->lastInsertId();

      $team_leader = 1;

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
      $stmt->bindValue(":team_leader_id", $team_leader, PDO::PARAM_STR);
      $stmt->bindValue(":authorized_units", 1, PDO::PARAM_STR);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      $register = $stmt->execute();

      $app = new App;

      // Enviar email al usuario con el token para que confirme su email
      // $sendUser = $app->sendEmail('Usuario', 'Contacto Usuario', $post);
      
      // Enviar un email para avisar al team leader asignado que tiene un nuevo lacayo 

      return $register;
      
    } catch (Exception $e) {
      // lanzar error
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
      // lanzar error
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

  public function setValuesUser($data)
  {

    $id = (int)$data['id_user'];

    $sql = "UPDATE users SET user = :user, email = :email WHERE id = '$id' ";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bindValue(":user", $data['user'], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);

    return $stmt->execute();

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

}

?>
