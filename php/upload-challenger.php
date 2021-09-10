<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	$chekFileType = [];
	$invalidFileType = false;
	$chekFileSize = [];
	$invalidFileSize = false;

	$comments = $_POST['comments'];

	// Si no hay archivos o datos en el post
	if ( 
		!isset($_FILES['files']) || 
		emptyInput($_POST['comments']) ||
		emptyInput($_POST['unit']) ||
		emptyInput($_POST['episode']) ||
		emptyInput($_POST['user']) ||
		emptyInput($_POST['team_leader'])
	) {
		header('Content-type: application/json');
		echo false; exit;
	}

	// chequeo el tipo de archivo
	foreach ($_FILES['files']['type'] as $key => $file) {
		if (
			$file == 'application/msword' || 
			$file == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 
			$file == 'application/vnd.ms-excel' || 
			$file == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || 
			$file == 'application/pdf' || 
			$file == 'application/msword'
		) {
			array_push($chekFileType, true);
		} else {
			array_push($chekFileType, false);
		}
	}

	// chequeo el peso del archivo
	foreach ($_FILES['files']['size'] as $key => $file) {
		if ( $file < 2097152 ) {
			array_push($chekFileSize, true);
		} else {
			array_push($chekFileSize, false);
		}
	}

	if (in_array(false, $chekFileType)) {
		$invalidFileType = true;
	}

	if (in_array(false, $chekFileSize)) {
		$invalidFileSize = true;
	}

	// Si se cargaron formatos y el peso incorrectos
	if ($invalidFileType || $invalidFileSize) {
		header('Content-type: application/json');
		echo false; exit;
	}

	$uploadChallenger = $db->getRepositorioEpisodes()->uploadChallenger($_FILES, $_POST);

	header('Content-type: application/json');
	echo json_encode($uploadChallenger);

?>