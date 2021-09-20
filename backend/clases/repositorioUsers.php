<?php

abstract class repositorioUsers {
	public abstract function login($email, $password);
	public abstract function getUsers();
	public abstract function changeUnitsAuthorized($id, $newUnit);
	public abstract function checkAuthUser();
}

?>