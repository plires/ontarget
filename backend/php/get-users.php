<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$users = $db->getRepositorioUsers()->getusers();

	header('Content-type: application/json');
	echo json_encode($users);

?>