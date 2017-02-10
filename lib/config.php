<?php

// set some universal settings
session_start();
error_reporting(E_ALL);

if (file_exists(dirname(__FILE__).'/define.php')) {
    include(dirname(__FILE__).'/define.php');
}
// check if SQL works, otherwise redirect to install
if (!defined("DB_HOST") || !defined("DB_USER") || !defined("DB_PASS") || !defined("DB_DATABASE") || !defined("DB_INSTALLED")) {
    header("Location: lib/install.php");
    exit;
}

// set up database
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
if ($db->connect_errno > 0) {
    die("<p>Problem with database settings :(</p>");
}

// autoload
function __autoload($class)
{
    require(dirname(__FILE__).'/'.$class.'.php');
}

// load functions from a seperate file
require(dirname(__FILE__).'/functions.php');

// set up stuff
$post = new Post();
$vb = new Verbalizer($post, $db);
$user = $vb->user;

$page = isset($_GET['page']) ? murder($_GET['page']) : false;
$id = isset($_GET['id']) ? murder($_GET['id']) : false;

if ($id) {
    if (!$post = $vb->constructPost($id)) {
        header("Location: ?");
        exit;
    }
}

//good to go;
