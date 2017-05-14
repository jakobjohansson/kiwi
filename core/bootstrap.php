<?php

use kiwi\Connection;
use kiwi\Query;
use kiwi\Filesystem;

if (!Filesystem::find('config.php')) {
    return;
}

return new Query(
    Connection::make(require 'config.php')
);
