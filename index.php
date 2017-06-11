<?php

// use composer in development mode
require 'vendor/autoload.php';
$query = require 'core/bootstrap.php';

try {
    kiwi\Router::loadRoutes('routes.php')->delegate();
} catch (Exception $e) {
    return kiwi\ErrorHandler::renderErrorView($e, $query);
}
