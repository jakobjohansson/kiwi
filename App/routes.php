<?php
/*
 * Routes file.
 * You can create your own custom routes in here, at the end of this file.
 */

$router->get('', 'PageController/index');
$router->get('blog', 'BlogController/index');
$router->get('admin', 'AdminController/index');
$router->get('admin/write', 'AdminController/create');
$router->get('admin/users', 'AdminController/users');
$router->get('admin/options', 'AdminController/options');
