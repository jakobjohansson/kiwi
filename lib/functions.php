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
	if ($post->getPublic() == 0) return;
	if ($post->getPublic() == 1) return "checked";
}

function get_feed($all = "null") {
	$feed = Post::getFeed($all);
	foreach ($feed as $f) {
		yield $f;
	}
}

function addPost() {
	$public = 0;
	if (isset($_POST['public'])) $public = 1;
	else $public = 0;
	Post::addPost($public, $_POST['title'], $_POST['content'], $_FILES['thumb']);
}

function removePost() {
	global $post;
	$post->removePost(get_id());
}

function updatePost() {
	global $post;
	$public = 0;
	if (isset($_POST['public'])) $public = 1;
	else $public = 0;
	$post->updatePost(get_id(), $public, $_POST['title'], $_POST['content'], $_FILES['thumb']);
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