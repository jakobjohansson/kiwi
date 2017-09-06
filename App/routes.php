<?php
/*
 * Routes file.
 * You can create your own custom routes in here, at the end of this file.
 */

// Warning: This route should not be used in production.
 $router->get('migrate', function () {
     kiwi\Database\Migration::refresh();
 });

 $router->get('', 'PageController/index');
