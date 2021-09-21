<?php

abstract class repositorioChallenger {
	public abstract function getChallengers();
	public abstract function getChallengerByUser($id);
	public abstract function markAsApprovedOneChallenge($id);
	public abstract function markAsApprovedAllChallengerFromThisUser($id);
}

?>