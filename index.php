<?php

require 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

try {
    $kernel = new kiwi\Kernel();
} catch (Throwable $e) {
    return kiwi\Error\ErrorHandler::render($e);
}

$kernel->run();
