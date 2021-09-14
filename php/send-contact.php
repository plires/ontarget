<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( 
		empty($_POST) || 
		emptyInput($_POST['name']) || 
		!emailValid($_POST['email']) || 
		emptyInput($_POST['phone']) || 
		emptyInput($_POST['comments']) 
		)
	{

		header('Content-type: application/json');
		echo false; exit;

	}
	
	$sendContact = $db->getRepositorioUsers()->sendContact($_POST);
	// $sendContact = $db->getRepositorioUsers()->sendEmail('pablo@librecomunicacion.net', 'asunto', '<p>parrafo listo</p>', 'pablolires@gmail.com', 'Pablo Lires', 'pablolires@gmail.com' );

	header('Content-type: application/json');
	echo json_encode($sendContact);

?>