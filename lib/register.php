<?php

if (file_exists(dirname(__FILE__).'/define.php')) {
    include(dirname(__FILE__).'/config.php');
} else {
    exit;
}

$error = false;

if (userExists()) {
    exit;
}

if (isset($_POST['submit'])) {
    if (!createUser()) {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="../admin/assets/css/style.css" rel="stylesheet" />
	<title>Welcome to VB</title>
</head>
<body class="login">
   <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 outer">
                <div class="inner">
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
                </div>
            </div>
        </div>
        <?php
        if ($error) {
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div id="response" style="opacity: 1;">Username already exists / passwords don't match.</div>
                </div>
            </div>
            <?php

        }
        ?>
    </div>
</body>
</html>
