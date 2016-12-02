<?php
/********************************************
* VB
* User class
* Copyright (c) 2016 Jakob Johansson
*********************************************/
if (file_exists(dirname(__FILE__).'/define.php')) {
	include(dirname(__FILE__).'/config.php');
} else exit;

if(userExists()) exit;

if (isset($_POST['submit'])) createUser();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="style.css" rel="stylesheet" />
	<title>Welcome to VB</title>
</head>
<body>
	<div id="wrap">
		<main>
			<h1>Make your account</h1>
			<p>Let's make an account! Just finish these last steps.</p>
			<form action="" method="post">
				<label for="username">Username</label>
				<input type="text" placeholder="e.g admin" name="username" id="username" />
				<label for="pass">Password</label>
				<input type="password" placeholder="e.g iLoveCats34" name="pass" id="pass" />
				<label for="passrepeat">Repeat password</label>
				<input type="password" name="passrepeat" id="passrepeat" />
				<input type="submit" value="Register" name="submit" />
			</form>
		</main>
	</div>
</body>
</html>