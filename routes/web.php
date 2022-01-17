<?php

$router = new \Bramus\Router\Router();

// User
$router->get( '/imgur/profiles/{$username}/edit', '\app\controllers\UserController@edit' );
$router->post( '/imgur/profiles/{$username}/update', '\app\controllers\UserController@update' );
$router->get( '/imgur/profiles/{$username}', '\app\controllers\UserController@show' );

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
$router->get('/imgur/galleries/images/{$slug}/edit', '\app\controllers\ImageController@edit');
$router->post('/imgur/galleries/images/{$slug}/update', '\app\controllers\ImageController@update');
$router->get('/imgur/galleries/images/{$slug}', '\app\controllers\ImageController@show');
$router->get('/imgur/galleries/{$slug}/images/add', '\app\controllers\ImageController@create');
$router->post('/imgur/galleries/{$slug}/images/add', '\app\controllers\ImageController@store');

// Gallery
$router->get('/imgur/galleries/create', '\app\controllers\GalleryController@create');
$router->post('/imgur/galleries/create', '\app\controllers\GalleryController@store');
$router->get('/imgur/galleries/{$slug}/edit', '\app\controllers\GalleryController@edit');
$router->post('/imgur/galleries/{$slug}/update', '\app\controllers\GalleryController@update');
$router->get('/imgur/galleries/{$slug}', '\app\controllers\GalleryController@show');
$router->delete('/imgur/test/{$id}', '\app\controllers\GalleryController@delete');

$router->run();