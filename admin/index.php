<?php
$root = "../";
require($root.'lib/config.php');

if (!auth()) {
    header("Location: login.php");
}

if ($page == "password" && $_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['new'] == $_POST['newre']) {
        if (!$user->setPassword($_POST['old'], $_POST['new'])) {
            echo "You entered wrong password!";
        } else {
            echo "Password successfully updated!";
        }
    } else {
        echo "The passwords didnt match!";
    }
    exit;
}

if ($page == "add" && $_SERVER['REQUEST_METHOD'] == "POST") {
    $public = 0;
    if (isset($_POST['public'])) {
        $public = 1;
    }
    echo $vb->addPost($public, $_POST['title'], $_POST['content']);
} elseif ($page == "logout") {
    $user->logOut();
    header("Location: ".$root."index.php");
} elseif ($page == "edit" && isset($id) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $public = 0;
    if (isset($_POST['public'])) {
        $public = 1;
    }
    echo $vb->updatePost($id, $public, $_POST['title'], $_POST['content']);
} elseif ($page == "remove" && isset($id)) {
    if ($vb->removePost($id)) {
        echo "Deleted";
    } else {
        echo "Error";
    }
} elseif ($page == "changeaccount" && $_SERVER['REQUEST_METHOD'] == "POST") {
    if ($user->updateUserFromAdminPage($_POST)) {
        echo "Settings updated!";
    } else {
        echo "An error occured.";
    }
    if (!empty($_POST['oldpassword']) && !empty($_POST['password']) && !empty($_POST['passrepeat'])) {
        if ($_POST['password'] === $_POST['passrepeat']) {
            if ($user->setPassword($_POST['oldpassword'], $_POST['password'])) {
                echo "<br/>Password updated!";
            } else {
                echo "<br/>Couldn't update password (old password couldn't be verified).";
            }
        } else {
            echo "<br/>Couldn't update password cause they didn't match.";
        }
    }

    // check if meta settings are changed
    $pagination = isset($_POST['pagination']) ? "true" : "false";
    $posts_per_page = $_POST['postsperpage'];
    $comments = isset($_POST['comments']) ? "true" : "false";
    $deactivate = isset($_POST['deactivate']) ? "false" : "true";

    $settings = [];

    if ($pagination !== $vb->pagination) {
        $settings['pagination'] = $pagination;
    }
    
    if ($posts_per_page !== $vb->posts_per_page) {
        $settings['posts_per_page'] = $posts_per_page;
    }

    if ($comments !== $vb->comments) {
        $settings['comments'] = $comments;
    }

    if ($deactivate !== $vb->active) {
        $settings['active'] = $deactivate;
    }

    if (count($settings) > 0) {
        $vb->updateMeta($settings);
    }
} else {
    ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/admin.js"></script>
	<!— [if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
	<![endif]—>
	<title>Admin</title>
</head>
<body>
    <div class="responsive-menu-button">
        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
    </div>
    <div class="responsive-menu-button-close">
        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
    </div>
    <main>
        <div class="container-fluid">
            <div class="row importante">
                <div class="col-xs-12 col-sm-10 col-sm-push-2 content">
                </div>
                <div class="col-xs-12 col-sm-2 col-sm-pull-10 text-center no-padding sidebar">
                    <h2 class="text-right dash">Dashboard</h2>
                    <div class="logo animated bounceIn">
                    <?php
                        echo strtoupper(substr($user->getName(), 0, 1)); ?>
                    </div>
                    <div class="below-logo">
                        <?=$user->getName()?>
                        <br/>
                        <?=$user->getPostCount()?> posts
                    </div>
                    <ul class="text-right loader hidden-xs">
                        <li data-page="overview" class="active">Overview</li>
                        <li data-page="write">Write</li>
                        <li data-page="account">Account</li>
                        <li data-page="site">Visit site</li>
                        <li data-page="logout">Log out</li>
                    </ul>
                    <ul class="text-right loader visible-xs-block">
                        <li data-page="overview" class="active">Overview</li>
                        <li data-page="write">Write</li>
                        <li data-page="account">Account</li>
                        <li data-page="site">Visit site</li>
                        <li data-page="logout">Log out</li>
                    </ul>
                    <footer>
                        <a href="https://github.com/jakobjohansson/Verbalizer" target="_blank">Git</a> - <a href="mailto:jakobjohansson2@icloud.com">Support</a>
                    </footer>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<?php

}
?>
