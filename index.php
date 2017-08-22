<?php

// use composer in development mode
require 'vendor/autoload.php';
require 'Core'.DIRECTORY_SEPARATOR.'bootstrap.php';

try {
    kiwi\Http\Router::loadRoutes('App'.DIRECTORY_SEPARATOR.'routes.php')->delegate();
} catch (Exception $exception) {
    return kiwi\Error\ErrorHandler::renderErrorView($exception);
}
