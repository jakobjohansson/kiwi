<?php
$root = "../../";
require($root.'lib/config.php');

if (!auth()) {
    header("Location: login.php");
}
?>
<h1>Write</h1>
<div class="row">
    <div class="col-xs-12 col-sm-9">
        <form action="?page=add" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="e.g what a wonderful day" />
            <label for="content">Content</label>
            <textarea name="content" id="content" placeholder="great inspirational quotes here"></textarea>
            <label for="public">
                <input type="checkbox" name="public" id="public" checked/> Public
            </label>
            <input type="submit" id="submit" name="submit" value="Add post!" />
        </form>
    </div>
    <div class="col-xs-12 col-sm-3">
        <h3>Psst!</h3>
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Use [code][/code] to highlight.<br/>
        <i class="fa fa-link" aria-hidden="true"></i> Use [link to=][/link] to print a link.<br/>
        <i class="fa fa-picture-o" aria-hidden="true"></i> Use [img]source[/img] to paste an image.
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-7">
        <div id="response"></div>
    </div>
</div>

