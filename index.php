<?php

require 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

try {
    $kernel = new kiwi\Kernel();
} catch (Exception $e) {
    return kiwi\Error\ErrorHandler::renderErrorView($e);
}

$kernel->run();
