<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$challenges = $db->getRepositorioEpisodes()->getChallenges();

	header('Content-type: application/json');
	echo json_encode($challenges);

?>