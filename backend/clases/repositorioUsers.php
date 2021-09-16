<?php

abstract class repositorioUsers {
	public abstract function login($email, $password);
	public abstract function getUsers();
}

?>