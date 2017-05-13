<?php
/**
 * Routes file
 * Create your own custom routes in here, at the end of this file.
 */

$router->get('install', 'Installer/index');
$router->get('install/step/{stepId}', 'installer/step');
