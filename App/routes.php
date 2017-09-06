<?php
/*
 * Routes file.
 * You can create your own custom routes in here, at the end of this file.
 */

 $router->get('migrate', function () {
     Migrate::refresh();
 });

$router->get('', 'PageController/index');
