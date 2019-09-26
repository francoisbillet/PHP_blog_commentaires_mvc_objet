<?php
require_once("model/Manager.php");

class PostManager extends Manager {
	public function getPosts() {
		$db = $this->dbConnect();
		$request = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

		return $request;
	}

	public function getPost($post_id) {
		$db = $this->dbConnect();
		$request = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %HH%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
		$request->execute(array($post_id));
		$post = $request->fetch();

		return $post;
	}

}