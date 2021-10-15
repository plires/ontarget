<?php

require_once( __DIR__ . "/repositorioEpisodes.php" );
require_once( __DIR__ . "/repositorioUsers.php" );

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__ . './../vendor/autoload.php';

class RepositorioEpisodesSQL extends repositorioEpisodes
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function uploadFiles($files) {

    // Creamos el array de respuesta
    $response = [];

    //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
    foreach($files["files"]['tmp_name'] as $key => $tmp_name)
    {

      //Validamos que el archivo exista
      if($files["files"]["name"][$key]) {
        $filename = $files["files"]["name"][$key]; //Obtenemos el nombre original del archivo
        $source = $files["files"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo

        $pathFile = "./../uploads/challengers/" . $filename;
        $ext = pathinfo($pathFile, PATHINFO_EXTENSION);

        $name = md5(rand(100, 200));
        $filenameModify = $name.'.'.$ext; //modificamos el nombre original del archivo

        $directorio = './../uploads/challengers/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
        
        //Validamos si la ruta de destino existe, en caso de no existir la creamos
        if(!file_exists($directorio)){
          mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");  
        }
        
        $dir=opendir($directorio); //Abrimos el directorio de destino
        $target_path = $directorio.'/'.$filenameModify; //Indicamos la ruta de destino, así como el nombre del archivo

        //Movemos y validamos que el archivo se haya cargado correctamente
        //El primer campo es el origen y el segundo el destino
        if(move_uploaded_file($source, $target_path)) { 

          $response[$key]['name_original'] = $filename;
          $response[$key]['path_real'] = BASE . 'uploads/challengers/' . $filenameModify;
          $response[$key]["path_to_delete"] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/challengers/' . $filenameModify;
          $response[$key]['result'] = true;

          } else {  

          $response[$key]['result'] = false;

        }

        closedir($dir); //Cerramos el directorio de destino

      }
    }

    return $response;

  }

  public function sendRequestZoom($post)
  {

    $comments_request_zoom = $post['comments_request_zoom'];
    $unit_number = $post['unit'];
    $episode_number = $post['episode'];
    $user_id = $post['user'];
    $team_leader_id = $post['team_leader'];
    $date = date("Y-m-d H:i:s");

    // 3- Verificar que el usuario no haya realizado una solicitud de zoom ya. Y si lo hizo pisar la anterior.
    $sql = "
      SELECT COUNT(*) FROM challenges_loaded 
      WHERE user_id = '$user_id'
      AND unit_number = '$unit_number' 
      AND episode_number = '$episode_number' 
      ";

    if ($resultado = $this->conexion->query($sql)) {

      try {

        // Grabar en base de datos
        $result = $this->saveChallengerInBdd( $resultado, $user_id, $unit_number, $episode_number, NULL, $comments_request_zoom, $date, $team_leader_id, NULL );

      } catch (Exception $e) {
        // Si no se pudo grabar en base de datos
        header("HTTP/1.1 500 Internal Server Error");
        
      }

    }

    if ($result === 'Zoom Cargado') {
      return 'Zoom Cargado';
    }

    // Editar el campo de desafios pendientes en la tabla users
    $user = new RepositorioUsersSQL($this->conexion);
    $user->updateChallengersPending($user_id);

    $template_user = file_get_contents('./../includes/emails/zoom-request/zoom-request-to-user.php');
    $template_client = file_get_contents('./../includes/emails/zoom-request/zoom-request-to-client.php');
    
    //configuro las variables a remplazar en el template
    $vars = array(
      '{leader_name}',
      '{leader_email}',
      '{user_name}',
      '{user_email}',
      '{comment}',
      '{date}',
      '{unit}',
      '{episode}',
      '{path_backend}',
      '{path}'
    );

    $values = array( 
      $post['team_leader_name'],
      $post['team_leader_email'],
      $post['user_name'],
      $post['user_email'],
      $comments_request_zoom,
      $date = date("Y-m-d"),
      $unit_number,
      $episode_number,
      PATH_BACKEND, 
      BASE
    );

    //Remplazamos las variables por las marcas en los templates
    $template_user = str_replace($vars, $values, $template_user);
    $template_client = str_replace($vars, $values, $template_client);

    // 3- Enviar mail al Usuario
    $this->sendmail(
      $post['team_leader_email'], // Remitente 
      $post['team_leader_name'], // Nombre Remitente 
      $post['team_leader_email'], // Responder a:
      $post['team_leader_name'], // Remitente al nombre: 
      $post['user_email'], // Destinatario 
      $post['user_name'], // Nombre del destinatario
      'Felicitaciones por completar un nuevo desafio.', // Asunto 
      $template_user // Template usuario
    );

    // 4- Enviar mail al Team Leader
    $this->sendmail(
      $post['user_email'], // Remitente 
      $post['user_name'], // Nombre Remitente 
      $post['user_email'], // Responder a:
      $post['user_name'], // Remitente al nombre: 
      $post['team_leader_email'], // Destinatario 
      $post['team_leader_name'], // Nombre del destinatario
      'Un usuario completo el desafio contactos y requiere un zoom.', // Asunto 
      $template_client // Template usuario
    );

    return true;

  }

  public function uploadChallenger($files, $post) {

    $comments = $post['comments'];
    $unit_number = $post['unit'];
    $episode_number = $post['episode'];
    $user_id = $post['user'];
    $team_leader_id = $post['team_leader'];
    $date = date("Y-m-d H:i:s");

    // 1- Guardar el archivo
    $uploadFiles = $this->uploadFiles($files);

    $paths_files_array = array_column($uploadFiles, 'path_real');
    $paths_files_json = json_encode($paths_files_array);

    // Verificamos si hubo algun error al subir los archivos
    $errorUpload = array_search(false, array_column($uploadFiles, 'result'));

    if ($errorUpload) {
      // Si no se pudiera cargar los archivos al servidor
      header("HTTP/1.1 500 Internal Server Error");
    }

    // 3- Verificar que el usuario no haya entregado esta unidad ya. Y si lo hizo
    // pisar la anterior.
    $sql = "
      SELECT COUNT(*) FROM challenges_loaded 
      WHERE user_id = '$user_id'
      AND unit_number = '$unit_number' 
      AND episode_number = '$episode_number' 
      ";

    if ($resultado = $this->conexion->query($sql)) {

      try {

        // Grabar en base de datos
        $result = $this->saveChallengerInBdd( $resultado, $user_id, $unit_number, $episode_number, $paths_files_json, $comments, $date, $team_leader_id, $uploadFiles );

      } catch (Exception $e) {
        // Si no se pudo grabar en base de datos
        header("HTTP/1.1 500 Internal Server Error"); 
        
      }

    }

    if ($result === 'Challenger Cargado') {
      return 'Challenger Cargado';
    }

    // Editar el campo de desafios pendientes en la tabla users
    $user = new RepositorioUsersSQL($this->conexion);
    $user->updateChallengersPending($user_id);

    $template_user = file_get_contents('./../includes/emails/challenger/challenger-upload-to-user.php');
    $template_client = file_get_contents('./../includes/emails/challenger/challenger-upload-to-client.php');
    
    //configuro las variables a remplazar en el template
    $vars = array(
      '{leader_name}',
      '{leader_email}',
      '{user_name}',
      '{user_email}',
      '{comment}',
      '{date}',
      '{unit}',
      '{episode}',
      '{path_backend}',
      '{path}'
    );

    $values = array( 
      $post['team_leader_name'],
      $post['team_leader_email'],
      $post['user_name'],
      $post['user_email'],
      $comments,
      $date = date("Y-m-d"),
      $unit_number,
      $episode_number,
      PATH_BACKEND, 
      BASE
    );

    //Remplazamos las variables por las marcas en los templates
    $template_user = str_replace($vars, $values, $template_user);
    $template_client = str_replace($vars, $values, $template_client);

    // 3- Enviar mail al Usuario
    $this->sendmail(
      $post['team_leader_email'], // Remitente 
      $post['team_leader_name'], // Nombre Remitente 
      $post['team_leader_email'], // Responder a:
      $post['team_leader_name'], // Remitente al nombre: 
      $post['user_email'], // Destinatario 
      $post['user_name'], // Nombre del destinatario
      'Felicitaciones por completar un nuevo desafio.', // Asunto 
      $template_user // Template usuario
    );

    // 4- Enviar mail al Team Leader
    $this->sendmail(
      $post['user_email'], // Remitente 
      $post['user_name'], // Nombre Remitente 
      $post['user_email'], // Responder a:
      $post['user_name'], // Remitente al nombre: 
      $post['team_leader_email'], // Destinatario 
      $post['team_leader_name'], // Nombre del destinatario
      'Un usuario completo un nuevo desafio.', // Asunto 
      $template_client // Template usuario
    );

    return true;

  }

  public function saveChallengerInBdd( $resultado, $user_id, $unit_number, $episode_number, $paths_files_json = NULL, $comments, $date, $team_leader_id, $uploadFiles = NULL ) {

    /* Comprobar el número de filas que coinciden con la sentencia SELECT */
    if ($resultado->fetchColumn() > 0) {

      //Verificamos si el desafio ya estaba aprobado para devolver el error indicando esto
      $stmt = $this->conexion->prepare("
        SELECT * 
        FROM challenges_loaded 
        WHERE user_id = '$user_id' 
        AND unit_number = '$unit_number' 
        AND episode_number = '$episode_number' 
        LIMIT 1
      ");
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_OBJ);

      if ($user->approved == 1 && $uploadFiles) { // si el desafio ya fue aprobado/leido y viene del modal-upload
        foreach ($uploadFiles as $file) {
          unlink($file['path_to_delete']);
        }
        return 'Challenger Cargado';

      } elseif ($user->approved == 1) { // si el desafio ya fue aprobado/leido y viene del modal-zoom-request
        return 'Zoom Cargado';
      }

      // editar el nuevo registro de entrega de desafio en la base de datos
      $sql = "
        UPDATE challenges_loaded 
        SET files = :files, comments = :comments, created_at = :created_at 
        WHERE user_id = '$user_id' 
        AND unit_number = '$unit_number' 
        AND episode_number = '$episode_number' 
        AND approved = 0 
      ";
        $stmt = $this->conexion->prepare($sql);

        $paths_files_json = $paths_files_json ? $paths_files_json : NULL;
        $stmt->bindValue(":files", $paths_files_json, PDO::PARAM_STR);
        $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
        $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);
        return $stmt->execute();

    } else {

      // Grabar el nuevo registro de entrega de desafio en la base de datos
      $sql = "
        INSERT INTO challenges_loaded 
        values(default, :user_id, :team_leader_id, :unit_number, :episode_number, :files, :comments, :approved, :created_at)
      ";

      $stmt = $this->conexion->prepare($sql);
      
      $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindValue(":team_leader_id", $team_leader_id, PDO::PARAM_INT);
      $stmt->bindValue(":unit_number", $unit_number, PDO::PARAM_INT);
      $stmt->bindValue(":episode_number", $episode_number, PDO::PARAM_INT);
      $stmt->bindValue(":files", $paths_files_json, PDO::PARAM_STR);
      $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
      $stmt->bindValue(":approved", 0, PDO::PARAM_INT);
      $stmt->bindValue(":created_at", $date, PDO::PARAM_STR);

      return $stmt->execute();
      
    }

  }

  public function getUnitById($id)
  {

    try {

      $sql = "SELECT * FROM units WHERE number = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $unit = $stmt->fetch(PDO::FETCH_ASSOC);

      return $unit;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }
 
  public function getEpisodes()
  {

    try {

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

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

  public function getChallenges()
  {

    try {

      $sql = "SELECT * FROM challenges";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $challenges;
      
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

}

?>
