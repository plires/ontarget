<?php

require_once("repositorioEpisodes.php");

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
          $response[$key]["path_to_delete"] = "/home/vagrant/proyectos/ontarget/uploads/challengers/" . $filenameModify;
          $response[$key]['result'] = true;

          } else {  

          $response[$key]['result'] = false;

        }

        closedir($dir); //Cerramos el directorio de destino

      }
    }

    return $response;

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

    return true;
    
    // 3- Enviar mail al TeamLeader
    // 4- Enviar mail al Usuario
    
    
  }

  public function saveChallengerInBdd( $resultado, $user_id, $unit_number, $episode_number, $paths_files_json, $comments, $date, $team_leader_id, $uploadFiles ) {

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

      if ($user->approved == 1) {
        foreach ($uploadFiles as $file) {
          unlink($file['path_to_delete']);
        }
        return 'Challenger Cargado';

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

}

?>
