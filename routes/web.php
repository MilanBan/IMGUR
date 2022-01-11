<?php

$router = new \Bramus\Router\Router();

$router->get( '/', function () {echo 'Hi from router.';} );
$router->get( '/user', '\app\controllers\UserController@user' );

$router->get('/login', '\app\controllers\AuthController@login');
$router->post('/login', '\app\controllers\AuthController@login');
$router->get('/register', '\app\controllers\AuthController@register');
$router->post('/register', '\app\controllers\AuthController@register');

$router->run();