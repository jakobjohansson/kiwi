<?php

// use composer in development mode
require 'vendor/autoload.php';
$query = require 'Core'.DIRECTORY_SEPARATOR.'bootstrap.php';

try {
    kiwi\Http\Router::loadRoutes('Custom'.DIRECTORY_SEPARATOR.'routes.php')->delegate();
} catch (Exception $exception) {
    return kiwi\Error\ErrorHandler::renderErrorView($exception);
}
