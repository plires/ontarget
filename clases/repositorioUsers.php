<?php

abstract class repositorioUsers {
	
	public abstract function getUserById($id);
	public abstract function getTeamLeaderById($id);
	public abstract function getUserByEmail($email);
	public abstract function login($email, $password);
	public abstract function register($post);
	public abstract function forgotPassword($email);
	public abstract function resetPassword($selector, $validator, $user_id);
	public abstract function newPass($post);
	public abstract function verifyTokenNewEmail($email, $token);
	public abstract function checkAuthUser();
	public abstract function saveCommentsToTeamLeader($post);
	public abstract function userEdit($post);
	public abstract function userBaja($post);
	public abstract function sendContact($post);
	public abstract function sendmail($setFromEmail, $setFromName, $addReplyToEmail, $addReplyToName, $addAddressEmail, $addAddressName, $subject, $template);
	public abstract function updateEmailInPerfit($post, $token, $team_leader, $verified_user, $authorizedUnits);
	public abstract function deleteEmailInPerfit($email);
	public abstract function getUserWithTeamLeader($id);

}

?>