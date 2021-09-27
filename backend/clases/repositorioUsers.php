<?php

abstract class repositorioUsers {
	public abstract function sendmail($setFromEmail,$setFromName,$addReplyToEmail,$addReplyToName,$addAddressEmail,$addAddressName,$subject,$template);
	public abstract function login($email, $password);
	public abstract function forgotPassword($email);
	public abstract function getUsers();
	public abstract function changeUnitsAuthorized($post);
	public abstract function checkAuthUser();
	public abstract function updateCommentsPending($userId);
	public abstract function updateChallengersPending($userId);
	public abstract function generateTokenAndSaveInDatabase($user);
	public abstract function newPass($post);

}

?>