<?php
$root = "../";
require($root.'lib/config.php');

if (!auth()) header("Location: login.php");

if($page == "add") {
	addPost();
} elseif ($page == "logout") {
	$user->logOut();
	header("Location: ".$root."index.php");
} elseif ($page == "edit" && isset($id) && $_SERVER['REQUEST_METHOD'] == "POST") {
	updatePost();
} elseif ($page == "remove" && isset($id)) {
	removePost();
} else {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="admin.css" rel="stylesheet" />
	<script src="jquery.js"></script>
	<script src="admin.js"></script>
	<title>Admin</title>
</head>
<body class="admin">
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<nav>
						<ul>
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
									<li><a href="">Change password</a></li>
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
						if ($page == "edit" && isset($id)) {
						?>
						<h2>Edit <?=get_title()?></h2>
						<form action="?page=edit&id=<?=get_ID()?>" method="post" enctype="multipart/form-data">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" placeholder="e.g what a wonderful day" value="<?=get_title()?>"/>
							<label for="content">Content</label>
							<textarea name="content" id="content" placeholder="great inspirational quotes here"><?=get_content()?></textarea>
							<label for="thumb">Optional image</label>
							<input type="file" name="thumb" id="thumb" />
							<label for="public">Public?</label>
							<input type="checkbox" name="public" id="public" <?=is_public()?>/>
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
							<label for="thumb">Optional image</label>
							<input type="file" name="thumb" id="thumb" />
							<label for="public">Public?</label>
							<input type="checkbox" name="public" id="public" checked/>
							<input type="submit" id="submit" name="submit" value="Add post!" />
						</form>
						<?php
						} else {
						?>
							<?php
							$feed = get_feed("all");
							foreach($feed as $f) {
								$content = nl2br($f['content']);
								echo "<article><h3><a href='../?id={$f['id']}'>{$f['title']}</a></h3>";
								echo "<p>$content</p>";
								echo "<p>{$f['date']}. <a href='?page=edit&id={$f['id']}'>Edit</a> - <a href='?page=remove&id={$f['id']}'>Remove</a></p></article>";
							}
						}
						?>
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