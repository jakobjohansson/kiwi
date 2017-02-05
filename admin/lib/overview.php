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
            $public = null;
            if ($post->public == 1) {
                $public = "<i class='option fa fa-globe fa-2x' alt='Public post'></i>";
            }
            echo "<article><h3>$post->title <small>$post->date</small></h3>";
            echo "$post->content";
            echo "<a href='../?id=$post->id'>Permalink</a> <a href='#' class='editor' data-id='$post->id'>Edit</a> <a href='?page=remove&id=$post->id' class='post-deleter'>Delete</a> <div class='delete-response'></div></article>";
        }?>
    </div>
</div>
