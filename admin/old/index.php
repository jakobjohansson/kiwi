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
    $vb->addPost($public, $_POST['title'], $_POST['content']);
} elseif ($page == "logout") {
    $user->logOut();
    header("Location: ".$root."index.php");
} elseif ($page == "edit" && isset($id) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $public = 0;
    if (isset($_POST['public'])) {
        $public = 1;
    }
    $vb->updatePost($id, $public, $_POST['title'], $_POST['content']);
} elseif ($page == "remove" && isset($id)) {
    $vb->removePost($id);
} else {
    ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="css/admin.css" rel="stylesheet" />
	<script src="js/jquery.js"></script>
	<script src="js/admin.js"></script>
	<title>Admin</title>
</head>
<body class="admin">
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<nav>
						<ul>
							<li><a href="../">Visit site</a></li>
							<li>
								Posts
								<ul>
									<li><a href="?">Overview</a></li>
									<li><a href="?page=write">Write</a></li>
								</ul>
							</li>
							<li>
								Account
								<ul>
									<li><a href="?page=password">Change password</a></li>
									<li><a href="">Remove account</a></li>
								</ul>
							</li>
							<li><a href="?page=logout">Log out</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>

	<main>


		<section>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<h1>Welcome <?=$user->getName()?>.</h1>
						<p>This is your admin page. To the top you can find the menu, where you can manage your posts and users.</p>
						<?php
                        if ($page == "password") {
                            ?>
						<h2>Change password</h2>
						<form action="?page=password" method="post" id="change">
							<label for="old">Old password</label>
							<input type="password" name="old" id="old" placeholder=". . . . ." />
							<label for="new">New password</label>
							<input type="password" name="new" id="new" placeholder=". . . . ." />
							<label for="newrepeat">Repeat new password</label>
							<input type="password" name="newre" id="newre" placeholder=". . . . ." />
							<div id="response"></div>
							<input type="submit" value="Change password" name="submit" />
						</form>
						<?php

                        } elseif ($page == "edit" && isset($id)) {
                            ?>
						<h2>Editing <?=$post->title?></h2>
						<form action="?page=edit&id=<?=$post->id?>" method="post" enctype="multipart/form-data">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" placeholder="e.g what a wonderful day" value="<?=$post->title?>"/>
							<label for="content">Content</label>
							<textarea name="content" id="content" placeholder="great inspirational quotes here"><?=getCode($post->content)?></textarea>
							<label for="public">
                                <i class='fa fa-globe fa-2x'></i> 
                                <input type="checkbox" name="public" id="public" <?=is_public($post)?>/>
                                </label>
							<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use [code][/code] to highlight.<br/>
							<i class="fa fa-link" aria-hidden="true"></i> Use [link to=][/link] to print a link.<br/>
                            <i class="fa fa-picture-o" aria-hidden="true"></i> Use [img]source[/img] to paste an image.
							<input type="submit" id="submit" name="submit" value="Edit post!" />
						</form>
						<?php

                        } elseif ($page == "write") {
                            ?>
						<h2>Write a post</h2>
						<form action="?page=add" method="post" enctype="multipart/form-data">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" placeholder="e.g what a wonderful day" />
							<label for="content">Content</label>
							<textarea name="content" id="content" placeholder="great inspirational quotes here"></textarea>
							<label for="public">
                                <i class='fa fa-globe fa-2x'></i>
                                <input type="checkbox" name="public" id="public" checked/>
                            </label>
							<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use [code][/code] to highlight.<br/>
							<i class="fa fa-link" aria-hidden="true"></i> Use [link to=][/link] to print a link.<br/>
                            <i class="fa fa-picture-o" aria-hidden="true"></i> Use [img]source[/img] to paste an image.
							<input type="submit" id="submit" name="submit" value="Add post!" />
						</form>
						<?php

                        } else {
                            while ($vb->loopPosts(true)) {
                                $public = null;
                                if ($post->public == 1) {
                                    $public = "<i class='option fa fa-globe fa-2x' alt='Public post'></i>";
                                }
                                echo "<article><h3><a href='../?id=$post->id'>$post->title</a></h3>";
                                echo "$post->content";
                                echo "<p>$post->date. <a href='?page=edit&id=$post->id'><i class='option fa fa-2x fa-pencil-square'></i></a><a href='?page=remove&id=$post->id'><i class='option fa fa-2x fa-trash'></i></a> $public</p></article>";
                            }
                        } ?>
					</div>
				</div>
			</div>
		</section>


	</main>
</body>
</html>

<?php

}
?>
