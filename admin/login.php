<?php
$root = "../";
require($root.'lib/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (User::login($_POST['username'], $_POST['password']) == true) {
        echo "Success!";
    } else {
        echo "Incorrect username or password.";
    }
    exit;
}

if (auth()) {
    header("Location: index.php");
} else {
    // content?>

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="css/admin.css" rel="stylesheet" />
		<script src="js/jquery.js"></script>
		<script src="js/admin.js"></script>
		<title>VB - Login</title>
	</head>
	<body class="login">

			<div class="container mid">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<div class="padd grey">
							<h1>Login</h1>
							<form action="" method="post" id="login">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" placeholder="e.g admin" />
								<label for="password">Password</label>
								<input type="password" name="password" id="password" />
								<input type="submit" value="Log in" name="submit" />
							</form>
						</div>
						<div id="response"></div>
					</div>
				</div>
			</div>

	</body>
	</html>
	<?php

}
?>
