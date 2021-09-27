<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( 
		empty($_POST) || 
		!emailValid($_POST['email']) || 
		emptyInput($_POST['name']) || 
		emptyInput($_POST['phone']) || 
		emptyInput($_POST['password']) || 
		strlen($_POST['password']) < 6 || 
		$_POST['password'] != $_POST['cpassword'] || 
		!$_POST['mayor_edad']
	) {

		header('Content-type: application/json');
		echo false; exit;

	}
	
	$user = $db->getRepositorioUsers()->register($_POST);

	header('Content-type: application/json');
	echo json_encode($user);

?>