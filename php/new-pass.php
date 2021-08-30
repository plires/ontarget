<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( empty($_POST) || emptyInput($_POST['password_reset']) || strlen($_POST['password_reset']) < 6 || $_POST['password_reset'] != $_POST['cpassword_reset'] ) {

		header('Content-type: application/json');
		echo false; exit;

	}

	$new_pass = $db->getRepositorioUsers()->newPass($_POST);

	header('Content-type: application/json');
	echo json_encode($new_pass);

?>