<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$episodes = $db->getRepositorioEpisodes()->getEpisodes();

	header('Content-type: application/json');
	echo json_encode($episodes);

?>