<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$users = $db->getRepositorioUsers()->getUsers();

	header('Content-type: application/json');
	echo json_encode($users);

?>