<?php

// use composer in development mode
require 'vendor/autoload.php';

$go = require 'core/bootstrap.php';

Router::loadRoutes('routes.php')->delegate();
