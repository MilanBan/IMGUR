<?php

$router = new \Bramus\Router\Router();

// Seeder
$router->get( '/seed', '\app\controllers\SeederController@seed' );

// Advertising
$router->get( '/advertising/{$name}','\app\controllers\AdvertisingController@countClicks');

// SubscriptionModel
$router->get('/imgur/profiles/{$username}/subscription', '\app\controllers\SubscriptionController@create');
$router->post('/imgur/profiles/{$username}/subscription', '\app\controllers\SubscriptionController@store');
$router->get('/imgur/profiles/{$username}/subscription/history', '\app\controllers\SubscriptionController@history');

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
$router->post('/imgur/galleries/images/{$id}', '\app\controllers\ImageController@delete');

// Gallery
$router->get('/imgur/galleries/create', '\app\controllers\GalleryController@create');
$router->post('/imgur/galleries/create', '\app\controllers\GalleryController@store');
$router->get('/imgur/galleries/{$slug}/edit', '\app\controllers\GalleryController@edit');
$router->post('/imgur/galleries/{$slug}/update', '\app\controllers\GalleryController@update');
$router->get('/imgur/galleries/{$slug}', '\app\controllers\GalleryController@show');
$router->post('/imgur/galleries/{$id}', '\app\controllers\GalleryController@delete');

// Comment
$router->post('/imgur/comments', '\app\controllers\CommentController@store');



$router->run();