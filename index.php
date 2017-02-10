<?php
require("lib/config.php");

if (!$vb->active && !$user->isAuth()) {
    if (file_exists("views/deactivated.php")) {
        require("views/deactivated.php");
    }
} else {
    if ($id) {
        if (file_exists("views/single.php")) {
            require("views/single.php");
        }
    } else {
        if (file_exists("views/flow.php")) {
            require("views/flow.php");
        }
    }
}
