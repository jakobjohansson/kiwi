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
    ?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <!— [if lt IE 9]>
        <script src="assets/js/html5shiv.js"></script>
    <![endif]—>
    <title>Login</title>
</head>
<body class="login">
	<div class="container">
		<div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 outer">
                <div class="inner">
                    <h1>Login</h1>
                    <form action="" method="post">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="e.g admin" />
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="bananas" />
                        <input type="submit" value="Log in" name="submit" />
                    </form>
                </div>
			</div>
		</div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div id="response"></div>
            </div>
        </div>
	</div>
</body>
</html>
<?php

}
