<?php
ob_start();
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
<?php

// if file exists, include to show error message
if (file_exists(dirname(__FILE__).'/define.php')) {
    include(dirname(__FILE__).'/define.php');
}

// if settings are already defined, tell user to delete define.php
if (!defined("DB_HOST") || !defined("DB_USER") || !defined("DB_PASS") || !defined("DB_DATABASE")) {

    //otherwise begin installation
    if (!isset($_POST['submit'])) {
        ?>

		<h1>Welcome to VB!</h1>
		<p>Take some time to configure the website. This is necessary for VB to run. Enter your database settings here. It will not be saved anywhere except on your computer. If you need help regarding the settings, contact your web administrator.</p>
		<form action="install.php" method="post">
			<label for="dbhost">Server</label>
			<input type="text" name="dbhost" id="dbhost" placeholder="e.g localhost" value="localhost" />
			<label for="dbuser">Database username</label>
			<input type="text" name="dbuser" id="dbuser" placeholder="e.g root, user, etc" />
			<label for="dbpass">Database password</label>
			<input type="password" name="dbpass" id="dbpass" placeholder="for new servers, this normally blank" />
			<label for="dbdb">Database</label>
			<input type="text" name="dbdb" id="dbdb" placeholder="enter the database name you have chosen" />
			<input type="submit" value="Try!" id="submit" name="submit" />
		</form>
			
	<?php

    } else {
        // execute after button is pressed
        $dbhost = filter_var($_POST['dbhost'], FILTER_SANITIZE_STRING);
        $dbuser = filter_var($_POST['dbuser'], FILTER_SANITIZE_STRING);
        $dbpass = filter_var($_POST['dbpass'], FILTER_SANITIZE_STRING);
        $dbdb = filter_var($_POST['dbdb'], FILTER_SANITIZE_STRING);

        // needs to do some string regexp here probably
        if (empty($dbhost) || empty($dbuser) || empty($dbpass) || empty($dbdb)) {
            echo "<h1>Error</h1><p>All fields need to be filled out.</p>";
            exit;
        }

        $file = fopen("define.php", "w");
        $write = "<?php\ndefine('DB_HOST', \"$dbhost\");\ndefine('DB_USER', \"$dbuser\");\ndefine('DB_PASS', \"$dbpass\");\ndefine('DB_DATABASE', \"$dbdb\");\n";
        if (fwrite($file, $write)) {
            fclose($file);
            // success!
            // create tables

            $db = new mysqli($dbhost, $dbuser, $dbpass, $dbdb);
            if ($db->connect_errno > 0) {
                unlink("define.php");
                header("Location: install.php?error");
                exit;
            }

            $sql = "DROP TABLE IF EXISTS `vb_post`; DROP TABLE IF EXISTS `vb_user`;";

            $sql .= "CREATE TABLE `vb_post` (
					 `id` int(11) NOT NULL AUTO_INCREMENT,
					 `title` varchar(255) NOT NULL,
					 `content` text NOT NULL,
					 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					 `authorID` int(11) DEFAULT NULL,
					 `authorName` varchar(255) NOT NULL,
					 `public` tinyint(1) NOT NULL DEFAULT '1',
					 PRIMARY KEY (`id`),
					 UNIQUE KEY `id` (`id`),
					 KEY `id_2` (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";

            $sql .= "CREATE TABLE `vb_user` (
					 `id` int(11) NOT NULL AUTO_INCREMENT,
					 `name` varchar(255) NOT NULL,
					 `postcount` int(11) NOT NULL DEFAULT '0',
					 `password` varchar(255) NOT NULL,
					 PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";

            if ($db->multi_query($sql) === false) {
                echo "<h1>Error</h1><p>An error occured while trying to add tables.</p>";
                exit;
            } else {
                $file = fopen("define.php", "a");
                $write = "define('DB_INSTALLED', true);";
                fwrite($file, $write);
                fclose($file); ?>
				<h1>Success!</h1>
				<p>Settings were successfully saved! Now, lets make your user!</p> 
				<p><a href="register.php">Make your user!</a></p>
				<?php

            }
            $db->close();
        } else {
            fclose($file); ?>

			<h1>Something went wrong</h1>
			<p>We couldn't make the define.php file. Please make sure the VB folder has write privelegies and try again.</p>
		<?php

        }
    }
} else {
    // error message
    ?>

	<h1>No access</h1>
	<p>You can't access this file after a successfull installation. If you have problems or your installation messed up, you can delete <strong>lib/define.php</strong> to start this process over. Note that your posts and users won't be removed - you only have to set up your connection again.</p>
<?php 
}
?>
		</main>
	</div>
	<?php
    if (isset($_GET['error'])) {
        echo "<div id='response'>Couldn't connect to database. Try again!</div>";
    }
    ?>
</body>
</html>
<?php
ob_end_flush();
?>
