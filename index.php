<?php

// use composer in development mode
require 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

try {
    kiwi\Http\Router::loadRoutes('App'.DIRECTORY_SEPARATOR.'routes.php')->delegate();
} catch (Exception $exception) {
    return kiwi\Error\ErrorHandler::renderErrorView($exception);
}
