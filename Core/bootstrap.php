<?php

use kiwi\Database\Connection;
use kiwi\Database\Model;
use kiwi\System\Filesystem;

if (!Filesystem::find('App'.DIRECTORY_SEPARATOR.'config.php')) {
    return;
}

Model::boot(Connection::make(require 'App'.DIRECTORY_SEPARATOR.'config.php'));
