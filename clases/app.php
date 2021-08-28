<?php
require __DIR__  . '/../vendor/autoload.php';
// require __DIR__  . '/../includes/config.inc.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

  class App 
  {

    public function sendEmail($destinatario, $template, $post)
    {
      switch ($destinatario) {
        case 'Cliente':
          $emailDestino = EMAIL_RECIPIENT;
          if (isset($post['name'])) {
            $nameShow = $post['name'];
            $emailAddReplyTo = $post['email'];
            $emailBCC = EMAIL_BCC;
          } else {
            $nameShow = $post['email'];
            $emailAddReplyTo = $post['email'];
            $emailBCC = EMAIL_BCC;
          }
          $emailShow = EMAIL_SENDER;  // Mi cuenta de correo
          break;
        
        case 'Usuario':
          $emailDestino = $post['email'];
          $nameShow = NAME_SENDER_SHOW;
          $emailShow = EMAIL_RECIPIENT;  // Mi cuenta de correo
          $emailAddReplyTo = EMAIL_SENDER_SHOW;
          $emailBCC = '';
          break;

        case 'Cliente CV':
          $emailDestino = EMAIL_RECIPIENT;
          $nameShow = 'Sitio Web Laboratorio IBC';
          $emailAddReplyTo = EMAIL_SENDER;
          $emailBCC = EMAIL_BCC;
          $emailShow = EMAIL_SENDER;  
          break;
      }

      switch ($template) {
        case 'Contacto Cliente':
          include("../includes/emails/contacts/template-envio-cliente.inc.php"); // Cargo el contenido del email a enviar al cliente.
          $subject = 'Nueva consulta desde el formulario web.';
          break;
        
        case 'Contacto Usuario':
          include("../includes/emails/contacts/template-envio-usuario.inc.php"); // Cargo el contenido del email a enviar al usuario.
          $subject = 'Gracias por su contacto.';
          break;

        case 'Send CV Cliente':
          $this->uploadCV($post);

          include("../includes/emails/cv/template-envio-cliente.inc.php"); // Cargo el contenido del email a enviar al cliente.
          $subject = 'Envio de CV desde Formulario web.';
          break;
      }

      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = EMAIL_SENDER;                     //SMTP username
        $mail->Password   = EMAIL_PASS;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = EMAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(EMAIL_SENDER_SHOW, NAME_SENDER_SHOW);
        $mail->addAddress('plires@depisos.com', 'Pablo Depisos');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo(EMAIL_SENDER_SHOW, NAME_SENDER_SHOW);
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = EMAIL_SUBJECT;
        $mail->Body    = $body;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        // $mail->SMTPOptions = array(
        //   'ssl' => array(
        //     'verify_peer' => false,
        //     'verify_peer_name' => false,
        //     'allow_self_signed' => true
        //   )
        // );

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

      // if ($emailBCC != '') { // si no esta vacio el campo BCC
      //   $mail->addBCC($emailBCC, $subject); // Copia del email
      // }

      

    }

    public function getURLBase()
    {

      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );

    }

    public function randomString()
    {
      return md5(rand(100, 200));
    }

    public function uploadCV($cv)
    {

      $name = $this->randomString();
      $ext = explode('.',$cv['name']);
      $filename = $name.'.'.$ext[1];

      // Cargamos la en variable de session el la ruta y nombre del archivo subido
      $_SESSION['cv'] = $filename;

      // $destination = $_SERVER['DOCUMENT_ROOT'] . '/IBC/sitio/uploads/' .$filename; // Para Local
      $destination = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$filename; // Para Produccion
      $location =  $cv['tmp_name'];

      return move_uploaded_file($location,$destination);

    }

    public function checkUploadCV($cv)
    {

      $errorsCV = [];

      if ($cv['size'] === 0) {

        if ($_SESSION['lang'] === 'es') {
          $errorsCV['empty'] = "Falta cargar un CV (máx: 2mb)";
        } else {
          $errorsCV['empty'] = "Upload a CV (máx: 2mb) (PDF, XLS, XLSX, DOC, DOCX, JPG, PNG & GIF).";
        }

      }

      if ($cv['size'] > 2000000) {

        if ($_SESSION['lang'] === 'es') {
          $errorsCV['size'] = "Tamaño máximo de archivo: 2mb";
        } else {
          $errorsCV['size'] = "Maximum file size: 2mb";
        }
        
      }

      if(
        $cv['type'] != "image/jpeg" && 
        $cv['type'] != "png" && 
        $cv['type'] != "gif" && 
        $cv['type'] != "application/pdf" && 
        $cv['type'] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && 
        $cv['type'] != "application/vnd.ms-excel" && 
        $cv['type'] != "application/msword" && 
        $cv['type'] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ) {

        if ($_SESSION['lang'] === 'es') {
          $errorsCV['type'] = "Tipos de archivos permitidos: PDF, XLS, XLSX, DOC, DOCX, JPG, PNG & GIF.";
        } else {
          $errorsCV['type'] = "Allowed file types: PDF, XLS, XLSX, DOC, DOCX, JPG, PNG & GIF.";
        }

      }

      return $errorsCV;

    }

  }

?>