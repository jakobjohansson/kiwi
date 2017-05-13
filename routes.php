<?php
/**
 * Routes file
 * Create your own custom routes in here, at the end of this file.
 */

$router->get('install', 'Installer/initiate');
$router->get('install/database', 'Installer/getDatabaseView');
$router->get('install/user', 'Installer/getUserView');
$router->get('install/success', 'Installer/getSuccessView');
