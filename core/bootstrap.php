<?php

use kiwi\Database\Connection;
use kiwi\System\Filesystem;
use kiwi\Http\Model;

if (!Filesystem::find('config.php')) {
    return;
}

Model::boot(Connection::make(require 'config.php'));
