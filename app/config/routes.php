<?php

/* setup the routes */

/*
$routes['#^unit/test$#i'] = 'main/unit_test';
$routes['#^user/(.*)$#i'] = 'main/user/$1';
$routes['#^app(.*)$#i'] = 'main/app$1';
$routes['#^rest/(.*)$#i'] = 'rest/index/$1';
*/

$routes['#^logout(.*)$#i'] = 'main/logout';
$routes['#^accessdenied(.*)$#i'] = 'main/notloggedin';