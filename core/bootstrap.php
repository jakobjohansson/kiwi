<?php

use kiwi\Filesystem;
use kiwi\Request;
use kiwi\Connection;

if (!Filesystem::find('config.php')) {
    return Request::redirect('install/');
}

return new Query(
    Connection::create(require 'config.php')
);
