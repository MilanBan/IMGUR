<?php

use app\models\Advertising;
use app\models\Session;
use app\models\Redis;
var_dump(Advertising::$banners['h']->image);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:,">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>IMGUR</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <a class="navbar-brand" href="/imgur"><strong>IMGUR</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (Session::get('user')): ?>
                <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == '/imgur/galleries') ? 'active' : '' ?>">
                    <a class="nav-link" href="/imgur/galleries">Galleries </a>
                </li>
                <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == '/imgur/profiles') ? 'active' : '' ?>">
                    <a class="nav-link" href="/imgur/profiles">Profiles <small><?= in_array(Session::get('user')->role, ['admin', 'moderator']) ? '(Administration)' : '' ?></small></a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
            <?php if (Session::get('user')): ?>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        plan: <?= (Session::get('subs') == 'free') ? 'Subscription' : Session::get('subs')?> <small class="<?= (Session::get('subs') == 'free') ? 'text-danger' : 'text-success'?>">(<?= Session::get('expire') ? ('expire in '.Session::get('expire')) : 'free' ?>)</small>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown">
                        <a class="dropdown-item" href="/imgur/profiles/<?= Session::get('username') ?>/subscription/history">Subscription History</a>
                        <a class="dropdown-item" href="/imgur/profiles/<?= Session::get('username') ?>/subscription/"><?= Session::get('subs') == 'free' ? 'Buy Subscription' : 'Renew Subscription'?></a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= ucwords(Session::get('user')->username) ?>
                        <?php if(Session::get('user')->role == 'admin') : ?>
                            <small>(A)</small>
                        <?php elseif (Session::get('user')->role == 'moderator') : ?>
                            <small>(M)</small>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/imgur/profiles/<?= Session::get('username') ?>">Profile </a>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <li class="nav-item active">
                    <?php if ($_SERVER['REQUEST_URI'] !== '/login'): ?>
                        <a class="nav-link" href="/login">Login</a>
                    <?php endif ?>
                </li>
                <li class="nav-item active">
                    <?php if ($_SERVER['REQUEST_URI'] !== '/register'): ?>
                        <a class="nav-link" href="/register">Register</a>
                    <?php endif ?>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 bg-primary vh-">
            <a href="/advertising/adv-left" >
                <div class="d-flex justify-content-center vh-90">
                    <div class="card bg-dark text-center text-white mtb-auto h-90" style="height: 100%; width: 100%;">
                        <img src="<?= Advertising::$banners['ls']->image ?>" class="card-img" alt="" >
                        <div class="card-img-overlay">
                            <p class="card-title text-right">ad</p>
                            <h1 class="card-title">L <?= Redis::exists('sector:clicks:adv-left') ? Redis::cached('sector:clicks:adv-left'):'' ?></h1>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-12 bg-warning max-vh-10" style="height: 100px;" >
                    <a href="/advertising/adv-header">
                        <div class="d-flex justify-content-center">
                            <div class="card bg-dark text-center text-white" style="height: 100px; width: 100%;" >
                                <img src="<?= Advertising::$banners['h']->image ?>" style="height: 100px;">
                                <div class="card-img-overlay p-2">
                                    <p class="card-title text-right">ad</p>
                                    <h1 class="card-title">H <?= Redis::exists('sector:clicks:adv-header') ? Redis::cached('sector:clicks:adv-header'):'' ?></h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12">


