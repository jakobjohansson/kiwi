<?php

function getCode($content)
{
    $content = str_replace('<span class="code">', '[code]', $content);
    $content = str_replace("</span>", '[/code]', $content);
    $content = str_replace('<a href="', '[link to=', $content);
    $content = str_replace("</a>", '[/link]', $content);
    $content = str_replace('">', ']', $content);
    return $content;
}

function murder($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function createUser()
{
    User::createUser($_POST['username'], $_POST['pass'], $_POST['passrepeat']);
}

function userExists()
{
    global $db;

    $sql = "SELECT * FROM `vb_user`";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function auth()
{
    global $user;
    return $user->isAuth();
}

function is_public($post)
{
    if ($post->public == 0) {
        return;
    }
    if ($post->public == 1) {
        return "checked";
    }
}
