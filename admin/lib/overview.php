<?php
$root = "../../";
require($root.'lib/config.php');

if (!auth()) {
    header("Location: login.php");
}
?>
<h1>Overview</h1>
<div class="row posts">
    <div class="col-xs-12 col-sm-10 col-md-8">
        <?php
        while ($vb->loopPosts(true)) {
            $public = ($post->public == 0) ? '<i class="fa fa-shield" aria-hidden="true"></i>' : null;
            echo "<article><h3>$post->title <small>$post->date $public</small></h3>";
            echo "$post->excerpt";
            echo "<div class='links'><a href='../?id=$post->id'>Permalink</a> <a href='#' class='editor' data-id='$post->id'>Edit</a> <a href='?page=remove&id=$post->id' class='post-deleter'>Trash</a></div></article>";
        }?>
    </div>
</div>
