<?php

abstract class repositorioComments {
	public abstract function getCommentsByUser($id);
	public abstract function getComments();
	public abstract function MarkAsReadOneComment($id);
	public abstract function markAsReadAllMessagesFromThisUser($userId);
}

?>