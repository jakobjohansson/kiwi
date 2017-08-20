<?php

use kiwi\Database\Connection;
use kiwi\Http\Model;
use kiwi\System\Filesystem;

if (!Filesystem::find('config.php')) {
    return;
}

Model::boot(Connection::make(require 'config.php'));
