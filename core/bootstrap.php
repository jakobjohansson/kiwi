<?php

use kiwi\Connection;
use kiwi\Filesystem;
use kiwi\Model;

if (!Filesystem::find('config.php')) {
    return;
}

Model::boot(Connection::make(require 'config.php'));
