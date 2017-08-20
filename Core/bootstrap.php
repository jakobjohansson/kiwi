<?php

use kiwi\Database\Connection;
use kiwi\Http\Model;
use kiwi\System\Filesystem;

if (!Filesystem::find('Custom'.DIRECTORY_SEPARATOR.'config.php')) {
    return;
}

Model::boot(Connection::make(require 'Custom'.DIRECTORY_SEPARATOR.'config.php'));
