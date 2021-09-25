<?php

abstract class repositorioUsers {
	public abstract function login($email, $password);
	public abstract function getUsers();
	public abstract function changeUnitsAuthorized($post);
	public abstract function checkAuthUser();
	public abstract function updateCommentsPending($userId);
	public abstract function updateChallengersPending($userId);
}

?>