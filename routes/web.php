<?php

$router = new \Bramus\Router\Router();

$router->get( '/', function () {echo 'Hi from router.';} );
$router->get( '/user', '\app\controllers\UserController@user' );

$router->run();