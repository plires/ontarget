<?php 

	include_once __DIR__ . '/../includes/soporte.php';
	include_once __DIR__ . '/../includes/functions.php';

	if ($_POST['mode_user_edit'] === 'true') {

		if ( 
			empty($_POST) || 
			emptyInput($_POST['name']) || 
			!emailValid($_POST['email']) || 
			emptyInput($_POST['phone']) || 
			emptyInput($_POST['city']) || 
			emptyInput($_POST['user_id']) || 
			!is_numeric($_POST['user_id']) || 
			emptyInput($_POST['password']) || 
			emptyInput($_POST['cPassword']) || 
			$_POST['password'] != $_POST['cPassword'] ||
			strlen($_POST['password']) < 6 || 
			strlen($_POST['cPassword']) < 6
			) 
		{

			header('Content-type: application/json');
			echo false; exit;

		}

	} else {

		if ( 
			empty($_POST) || 
			emptyInput($_POST['name']) || 
			!emailValid($_POST['email']) || 
			emptyInput($_POST['phone']) || 
			emptyInput($_POST['city']) || 
			emptyInput($_POST['user_id']) || 
			!is_numeric($_POST['user_id'])
			)
		{

			header('Content-type: application/json');
			echo false; exit;

		}

	}
	
	$userEdit = $db->getRepositorioUsers()->userEdit($_POST);

	header('Content-type: application/json');
	echo json_encode($userEdit);

?>