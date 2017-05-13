<?php

// use composer in development mode
require 'vendor/autoload.php';
require 'core/bootstrap.php';

try {
    kiwi\Router::loadRoutes('routes.php')->delegate();
} catch (Exception $e) {
    echo $e->getMessage();
}
