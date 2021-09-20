<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$challengers_loaded = $db->getRepositorioChallenger()->getChallengers();

	header('Content-type: application/json');
	echo json_encode($challengers_loaded);

?>