<?php

abstract class repositorioUsers {
	public abstract function getUserById($id);
	public abstract function setValuesUser($data);
	public abstract function getUserByEmail($email);
	public abstract function sendNewPassword($user);
	public abstract function setPasswordUser($data);
	public abstract function login($email, $password);
	public abstract function register($post);
}

?>