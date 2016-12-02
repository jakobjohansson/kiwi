<?php
/********************************************
* VB
* User class
* Copyright (c) 2016 Jakob Johansson
*********************************************/

class User {
	protected $id;
	protected $name;
	protected $status;
	protected $postcount;
	protected $loggedIn = false;

	// autoconstruct
	function __autoconstruct() {
		$this->name = $_SESSION['username'] ?? null;
		$this->id = $_SESSION['id'] ?? null;
		$this->loggedIn = (isset($_SESSION['username'])) ? true : null;
	}

	// getters
	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getPostCount() {
		return $this->postcount;
	}

	public function isAuth() {
		return $this->loggedIn;
	}

	// log out 
	public function logOut() {
		session_unset();
		session_destroy();
		$this->loggedIn = false;
	}

	// STATICS

	// create user
	public static function createUser($username, $pass, $passrepeat) {
		global $db;

		if ($pass != $passrepeat) die("Password don't match");
		// validate
		$username = trim($username);
		$pass = trim($pass);

		$username = htmlspecialchars($username);
		$pass = htmlspecialchars($pass);

		$pass = password_hash($pass, PASSWORD_DEFAULT);

		// check if username already exist
		$sql = "SELECT * FROM `vb_user` WHERE name = '$username'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) die("That username already exists.");
		$result->free();

		//proceed to add user
		$stmt = $db->prepare("INSERT INTO `vb_user` (name, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $username, $pass);
		if ($stmt->execute()) {
			$last = $db->insert_id;
			$_SESSION['username'] = $username;
			$_SESSION['id'] = $last;
			//success, redirect to welcome page
			header("Location: welcome.php");
		}
		$stmt->close();
	}
}

?>