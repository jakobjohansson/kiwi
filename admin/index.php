<?php
$root = "../";
require($root.'lib/config.php');

if (!auth()) {
	header("Location: login.php");
} else { 

}
?>