<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../../includes/functions.php';
	
	if ( empty($_POST) || emptyInput($_POST['id']) || !is_numeric($_POST['id']) ) {

		header('Content-type: application/json');
		echo false; exit;

	}
	
	$user = $db->getRepositorioUsers()->updateChallengersPending($_POST['id']);

	header('Content-type: application/json');
	echo json_encode($user);

?>