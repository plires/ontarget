<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';
	
	if ( empty($_POST) || !emailValid($_POST['email']) || emptyInput($_POST['password']) ) {
		header('Content-type: application/json');
		echo false; exit;
	}

	$user = $db->getRepositorioUsers()->login($_POST['email'], $_POST['password']);

	header('Content-type: application/json');
	echo json_encode($user);

?>