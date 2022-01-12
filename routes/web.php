<?php

$router = new \Bramus\Router\Router();

$router->get( '/', function () {echo 'Hi from router.';} );
$router->get( '/user', '\app\controllers\UserController@user' );

$router->get('/login', '\app\controllers\AuthController@login');
$router->post('/login', '\app\controllers\AuthController@login');
$router->get('/register', '\app\controllers\AuthController@register');
$router->post('/register', '\app\controllers\AuthController@register');
$router->get('/logout', '\app\controllers\AuthController@logout');

$router->get('/imgur', '\app\controllers\SiteController@images');
$router->get('/imgur/galleries', '\app\controllers\SiteController@galleries');
$router->get('/imgur/profiles', '\app\controllers\SiteController@profiles');



$router->run();