<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	$comments_request_zoom = $_POST['comments_request_zoom'];

	// Si no se completo el textarea de solicitud de zoom
	if (!$comments_request_zoom) {
		header('Content-type: application/json');
		echo false; exit;
	}

	$requestZoom = $db->getRepositorioEpisodes()->sendRequestZoom($_POST);

	header('Content-type: application/json');
	echo json_encode($requestZoom);

?>