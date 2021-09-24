<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ( empty($_POST) || 
		emptyInput($_POST['team_leader_id']) || 
		emptyInput($_POST['user_id']) || 
		emptyInput($_POST['comment']) || 
		!is_numeric($_POST['team_leader_id']) || 
		!is_numeric($_POST['user_id'])
	) {

		header('Content-type: application/json');
		echo false; exit;

	}
	
	$saveComment = $db->getRepositorioUsers()->saveCommentsToTeamLeader($_POST);

	header('Content-type: application/json');
	echo json_encode($saveComment);

?>