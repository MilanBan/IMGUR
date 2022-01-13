<?php

$router = new \Bramus\Router\Router();

$router->get( '/', function () {echo 'Hi from router.';} );
$router->get( '/user', '\app\controllers\UserController@user' );
// Auth
$router->get('/login', '\app\controllers\AuthController@login');
$router->post('/login', '\app\controllers\AuthController@login');
$router->get('/register', '\app\controllers\AuthController@register');
$router->post('/register', '\app\controllers\AuthController@register');
$router->get('/logout', '\app\controllers\AuthController@logout');
// Site
$router->get('/imgur', '\app\controllers\SiteController@images');
$router->get('/imgur/galleries', '\app\controllers\SiteController@galleries');
$router->get('/imgur/profiles', '\app\controllers\SiteController@profiles');

// Image
$router->get('/imgur/galleries/images/{$slug}', '\app\controllers\ImageController@show');


// Gallery
$router->get('/imgur/galleries/{$slug}/edit', '\app\controllers\GalleryController@edit');
$router->post('/imgur/galleries/{$slug}/update', '\app\controllers\GalleryController@update');
$router->get('/imgur/galleries/{$slug}', '\app\controllers\GalleryController@show');

$router->run();