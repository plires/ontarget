<?php 

////////////////////////
///Valores URI
////////////////////////
define('URI', $_SERVER['REQUEST_URI']);
define ('BASE', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' );

////////////////////////
///Valores de DB Remota
////////////////////////
define('DSN', 'mysql:host=localhost;dbname=lc_ontarget;charset=utf8;port:3306');
define('DB_USER', 'homestead');
define('DB_PASS', 'secret');

//////////////////////////////
///Valores de Envio de emails
//////////////////////////////
define('SMTP', 'smtp.librecomunicacion.net'); 
define('EMAIL_SENDER', 'pruebas@librecomunicacion.net');
define('EMAIL_PASS', 'Perezzs$7478'); 
define('EMAIL_SENDER_SHOW', 'pruebas@librecomunicacion.net');
define('NAME_SENDER_SHOW', 'On Target');
define('EMAIL_RECIPIENT', 'carlos.castro.1975.2@gmail.com');
define('EMAIL_BCC', '');
define('EMAIL_PORT', 587);
define('EMAIL_NAME', 'On Target');
define('EMAIL_SUBJECT', 'Gracias por tu contacto');
define('EMAIL_CHARSET', 'utf-8');
define('EMAIL_ENCODING', 'quoted­printable');

?>