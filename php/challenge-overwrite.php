<?php 

	include_once __DIR__ . '/../includes/soporte.php';

	$db->getRepositorioUsers()->newPass($_POST);

	header('Content-type: application/json');
	echo json_encode($confirm);

?>