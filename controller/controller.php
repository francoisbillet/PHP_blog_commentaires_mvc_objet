<?php

// Chargement des classes (une seule fois)
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function listPosts() {
	$postManager = new PostManager();
	$posts = $postManager->getPosts();

	require('view/listPostsView.php');
}

function post() {
	$postManager = new PostManager();
	$commentManager = new CommentManager();

	$post = $postManager->getPost($_GET['id']);
	$comments = $commentManager->getComments($_GET['id']);

	require('view/postView.php');
}

function addComment($post_id, $author, $comment) {
	$commentManager = new CommentManager();

	$affectedLines = $commentManager->postComment($post_id, $author, $comment);

	if ($affectedLines == false) {
		throw new Exception('Impossible d\'ajouter le commentaire');
	}
	else {
		header('Location: index.php?action=post&id=' . $post_id);
	}
}

function comment() {
	$postManager = new PostManager();
	$commentManager = new CommentManager();

	$post = $postManager->getPost($_GET['id']);
	$comment = $commentManager->getComment($_GET['comment_id']);

	require('view/modifyCommentView.php');
}

function modifyComment($post_id, $comment_id, $comment) {
	$commentManager = new CommentManager();

	$updateComment = $commentManager->updateComment($comment_id, $comment);

	if (!$updateComment) {
		throw new Exception('Impossible de modifier le commentaire');
	}
	else {
		header('Location: index.php?action=post&id=' . $post_id);
	}

	// require('view/modifyCommentView');
}
