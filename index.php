<?php
require("lib/config.php");
if ($page == "view" && $id) {
    require("views/single.php");
} else {
    require("views/flow.php");
}
