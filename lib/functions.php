<?php

function murder($data) {
	$data = trim($data);
	$data = stripslashes($data);
	return $data;
}

function get_title() {
	global $post;
	return $post->getTitle();
}

function get_content() {
	global $post;
	return $post->getContent();
}

function get_date() {
	global $post;
	return $post->getDate();
}

function get_author($id = null) {
	global $post;
	if ($id == null) {
		return $post->getAuthorName();
	} else {
		return $post->getAuthorID($id);
	}
}

function get_thumb() {
	global $post;
	return $post->getThumb();
}

function get_id() {
	global $post;
	return $post->getID();
}

function get_url() {
	global $post;
	$url = "index.php?id=".$post->getID();
	return $url;
}

function is_public() {
	global $post;
	if ($post->getPublic() == 0) return false;
	if ($post->getPublic() == 1) return true;
}

function get_feed() {
	$feed = Post::getFeed();
	foreach ($feed as $f) {
		yield $f;
	}
}

function addPost() {
	Post::addPost($_POST['title'], $_POST['content'], $_POST['thumb']);
}

function removePost() {
	global $post;
	$post->removePost();
}

function updatePost() {
	global $post;
	$post->updatePost($_POST['public'], $_POST['title'], $_POST['content'], $_POST['thumb']);
}

function createUser() {
	User::createUser($_POST['username'], $_POST['pass'], $_POST['passrepeat']);
}

function userExists() {
	global $db;

	$sql = "SELECT * FROM `vb_user`";
	$result = $db->query($sql);
	if ($result->num_rows > 0) return true;
	else return false;
}

function auth() {
	global $user;
	return $user->isAuth();
}
?>