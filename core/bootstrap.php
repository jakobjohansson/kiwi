<?php

use kiwi\Connection;
use kiwi\Filesystem;
use kiwi\Query;

if (!Filesystem::find('config.php')) {
    return;
}

return new Query(
    Connection::make(require 'config.php')
);
