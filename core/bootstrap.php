<?php

use kiwi\Filesystem;
use kiwi\Connection;

if (!Filesystem::find('config.php')) {
    return header("Location: install/");
}

return Connection::create(require 'config.php');
