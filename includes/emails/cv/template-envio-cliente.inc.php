<?php 
//Confeccionamos el HTML con los datos del usuario
$body='
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es_ar">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Instituto Biológico Contemporaneo</title>

  <style type="text/css">
  </style>    
</head>
<body style="margin:0; padding:0; background-color:#fff;">
  <center>
    <table bgcolor="#fff" width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
          <td height="40">&nbsp;</td>
       </tr>
      <tr>
      <tr>
          <td align="center" valign="top">
            <img src="http://laboratorioibc.com.ar/img/emails/logo-ibc-mail.gif" style="margin:0; padding:0; border:none; display:block;" border="0" alt="logo" /> 
          </td>
      </tr>
       <tr>
          <td height="40">&nbsp;</td>
      </tr>
      <tr>
          <td align="center" valign="top" style="font-size:18px; line-height:30px;"><strong>Instituto Biológico Contemporaneo - Envio de CV</strong></td>
      </tr>
      <tr>
           <td height="10">&nbsp;</td>
      </tr>

      <tr>
          <td align="center" valign="top" style="font-size:16px; line-height:30px;">
            <p><strong>CV Enviado: </strong>
              <a href="http://www.ibclab.com.ar/download.php/?file='.$_SESSION['cv'].'"> Descargar</a>
            </p>
          </td>
      </tr>

      <tr>
           <td height="10">&nbsp;</td>
      </tr>
      
      <tr>
          <td align="center" valign="top" style="font-size:16px; line-height:30px;"><p><strong>Fecha: </strong>'.date("F j, Y, g:i a").'</p></td>
      </tr>

      <tr>
           <td height="40">&nbsp;</td>
      </tr>

    </table>
  </center>
</body>
</html>
';
?>