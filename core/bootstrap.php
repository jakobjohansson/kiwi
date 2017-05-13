<?php

use kiwi\Request;
use kiwi\Connection;
use kiwi\Filesystem;

if (!Filesystem::find('config.php')) {
    return Request::redirect('/install');
}

return new Query(
    Connection::create(require 'config.php')
);
