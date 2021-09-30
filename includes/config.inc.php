<?php 

////////////////////////
///Valores URI
////////////////////////
define('URI', $_SERVER['REQUEST_URI']);
define ('BASE', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' );
define('RRSS_FACEBOOK', 'https://www.facebook.com/ontargetonline');
define('RRSS_INSTAGRAM', 'https://www.instagram.com/ontargetonline/');
define('RRSS_LINKEDIN', 'https://www.linkedin.com/company/ontargetonline');
define('PATH_BACKEND', 'http://ontarget.test/backend/');
define('ENVIRONMENT', 'local');

////////////////////////
///Valores de DB Remota
////////////////////////
define('DSN_APP', 'mysql:host=localhost;dbname=lc_ontarget;charset=utf8;port:3306');
define('DB_USER_APP', 'homestead');
define('DB_PASS_APP', 'secret');

//////////////////////////////
///Valores de Envio de emails
//////////////////////////////
define('SMTP', '0.0.0.0'); 
define('USERNAME', 'testuser');
define('PASSWORD', 'testpwd'); 
define('EMAIL_ONTARGET', 'info@ontargetonline.com.ar');
define('EMAIL_SENDER_SHOW', 'info@ontargetonline.com.ar');
define('NAME_ONTARGET', 'On Target');
define('NAME_SENDER_SHOW', 'On Target');
define('EMAIL_BCC', '');
define('EMAIL_PORT', 1025);
define('EMAIL_NAME', 'On Target');
define('EMAIL_SUBJECT', 'Gracias por tu contacto');
define('EMAIL_CHARSET', 'utf-8');
define('EMAIL_ENCODING', 'quoted printable');

?>