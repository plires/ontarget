<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	
	$comments = $db->getRepositorioComments()->getComments();

	header('Content-type: application/json');
	echo json_encode($comments);

?>