<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	$user = $db->getRepositorioUsers()->checkAuthUser();

	header('Content-type: application/json');
	echo json_encode($user);

?>