<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$user = $db->getRepositorioUsers()->checkAuthUser();

	header('Content-type: application/json');
	echo json_encode($user);

?>