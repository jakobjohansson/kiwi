<?php
/*
 * Routes file.
 * You can create your own custom routes in here, at the end of this file.
 */

$router->get('', 'PageController/index');
$router->get('blog', 'BlogController/index');
$router->get('admin', 'AdminController/index');