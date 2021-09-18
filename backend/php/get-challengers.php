<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$challengers_loaded = $db->getRepositorioUsers()->getChallengers();

	header('Content-type: application/json');
	echo json_encode($challengers_loaded);

?>