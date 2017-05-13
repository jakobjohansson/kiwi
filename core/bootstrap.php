<?php

use kiwi\Filesystem;
use kiwi\Request;
use kiwi\Connection;
use kiwi\Installer;

if (!Filesystem::find('config.php')) {
    return Installer::initiate();
}

return new Query(
    Connection::create(require 'config.php')
);
