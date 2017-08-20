<?php

// use composer in development mode
require 'vendor/autoload.php';
$query = require 'Core'.DIRECTORY_SEPARATOR.'bootstrap.php';

try {
    kiwi\Router::loadRoutes('Custom'.DIRECTORY_SEPARATOR.'routes.php')->delegate();
} catch (Exception $exception) {
    return kiwi\ErrorHandler::renderErrorView($exception);
}
