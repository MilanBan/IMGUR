<?php
use app\models\Session;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="data:,">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                    <a class="nav-link" href="/imgur/profiles">Profiles </a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
            <?php if (Session::get('user')): ?>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= Session::get('user')->username ?>
                        <?php if(Session::get('user')->role == 'admin') : ?>
                            <small>(A)</small>
                        <?php elseif (Session::get('user')->role == 'moderator') : ?>
                            <small>(M)</small>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Profile </a>
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
