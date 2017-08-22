<?php

use kiwi\Database\Connection;
use kiwi\Database\Model;
use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;
use kiwi\System\Filesystem;

if (!Filesystem::find('App'.DIRECTORY_SEPARATOR.'config.php')) {
    return;
}

Model::boot(
    Connection::make(
        require 'App'.DIRECTORY_SEPARATOR.'config.php'
    )
);

try {
    Router::loadRoutes(
        'App'.DIRECTORY_SEPARATOR.'routes.php'
    )->delegate();
} catch (Exception $exception) {
    return ErrorHandler::renderErrorView($exception);
}
