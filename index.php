<?php
require("lib/config.php");
if ($id) {
    require("views/single.php");
} else {
    require("views/flow.php");
}
