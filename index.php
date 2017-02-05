<?php
require("lib/config.php");
if ($id) {
    if (file_exists("views/single.php")) {
        require("views/single.php");
    }
} else {
    if (file_exists("views/flow.php")) {
        require("views/flow.php");
    }
}
