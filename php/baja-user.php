<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( 
		empty($_POST) || 
		emptyInput($_POST['user_id']) ||
		!is_numeric($_POST['user_id'])
		)
	{

		header('Content-type: application/json');
		echo false; exit;

	}
	
	$userBaja = $db->getRepositorioUsers()->userBaja($_POST);

	header('Content-type: application/json');
	echo json_encode($userBaja);

?>