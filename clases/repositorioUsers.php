<?php

abstract class repositorioUsers {
	public abstract function getUserById($id);
	public abstract function setValuesUser($data);
	public abstract function getUserByEmail($email);
	public abstract function login($email, $password);
	public abstract function register($post);
	public abstract function forgotPassword($email);
	public abstract function resetPassword($selector, $validator, $user_id);
	public abstract function newPass($post);
	public abstract function verifyTokenNewEmail($email, $token);
	public abstract function checkAuthUser();
}

?>