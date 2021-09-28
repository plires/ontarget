<?php

abstract class repositorioEpisodes {
	public abstract function getUnitById($id);
	public abstract function getEpisodes();
	public abstract function getChallenges();
	public abstract function uploadChallenger($files, $post);
	public abstract function sendmail($setFromEmail,$setFromName,$addReplyToEmail,$addReplyToName,$addAddressEmail,$addAddressName,$subject,$template);
}

?>