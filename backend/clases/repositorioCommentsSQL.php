<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './../../vendor/autoload.php';

require_once("repositorioComments.php");

class RepositorioCommentsSQL extends repositorioComments
{
  protected $conexion;

  public function __construct($conexion) 
  {
    $this->conexion = $conexion;
  }

  public function MarkAsReadOneComment($id) 
  {

    try {

      $sql = "UPDATE comments SET unread = :unread WHERE id = '$id' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->bindValue(":unread", 0, PDO::PARAM_INT);
      $stmt->execute();

      return true;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

  public function markAsReadAllMessagesFromThisUser($userId) 
  {

    try {

      $sql = "UPDATE comments SET unread = :unread WHERE user_id = '$userId' ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->bindValue(":unread", 0, PDO::PARAM_INT);
      $stmt->execute();

      return true;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

  public function getCommentsByUser($id) 
  {

    try {

      $sql = "
        SELECT * FROM comments 
        WHERE user_id = '$id' 
        ORDER BY created_at DESC
      ";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $comments;
      
    } catch (Exception $e) {

      header("HTTP/1.1 500 Internal Server Error"); 
           
    }

  }

}

?>
