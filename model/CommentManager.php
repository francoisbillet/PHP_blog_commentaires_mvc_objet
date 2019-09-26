<?php
require_once("model/Manager.php");

class CommentManager extends Manager {
	public function getComments($post_id) {
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
		$comments->execute(array($post_id));

		return $comments;
	}

	public function getComment($comment_id) {
		$db = $this->dbConnect();
		$request = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id = ?');
		$request->execute(array($comment_id));
		$comment = $request->fetch();

		return $comment;
	}


	public function postComment($post_id, $author, $comment) {
		$db = $this->dbConnect();
		$request = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
		$affectedLines = $request->execute(array($post_id, $author, $comment));

		return $affectedLines;
	}

	public function updateComment($comment_id, $comment) {
		$db = $this->dbConnect();
		$request = $db->prepare('UPDATE comments SET comment = ? WHERE id = ?');
		$updateComment = $request->execute(array($comment, $comment_id));

		return $updateComment;
	}
}