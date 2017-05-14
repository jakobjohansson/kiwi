<?php
$router->get('', 'Installer/initiate');
$router->post('test', 'Installer/postTestConnection');
$router->get('database', 'Installer/getDatabaseView');
$router->post('database', 'Installer/postDatabase');
$router->get('user', 'Installer/getUserView');
$router->post('user', 'Installer/postUserView');
$router->get('success', 'Installer/getSuccessView');
$router->get('remove', 'RecursiveRemover/init');
