<?php
$router->get('install', 'Installer/initiate');
$router->get('install/database', 'Installer/getDatabaseView');
$router->post('install/database', 'Installer/postDatabase');
$router->get('install/user', 'Installer/getUserView');
$router->post('install/user', 'Installer/postUserView');
$router->get('install/success', 'Installer/getSuccessView');
$router->post('install/test', 'Installer/postTestConnection');
$router->get('install/remove', 'RecursiveRemover/removeInstall');
