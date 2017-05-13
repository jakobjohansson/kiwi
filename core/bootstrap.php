<?php

use kiwi\Filesystem;
use kiwi\Request;
use kiwi\Connection;

if (!Filesystem::find('config.php')) {
    return Request::redirect('install/');
}

return Connection::create(require 'config.php');
