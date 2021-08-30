<?php 


	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( empty($_POST) || !emailValid($_POST['email']) ) {

		header('Content-type: application/json');
		echo false; exit;

	}

	$new_pass = $db->getRepositorioUsers()->forgotPassword($_POST);

	header('Content-type: application/json');
	echo json_encode($new_pass);

?>