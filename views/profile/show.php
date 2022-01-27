<?php

use app\models\Helper;
use app\models\Session;

?>
<div class="d-flex flex-wrap justify-content-center">
    <div class="border-bottom rounded-pill">
        <?php if (Session::getFlash('msg')): ?>
        <div class="p-3 bg-success text-white">
            <h3 class=""><?= Session::getFlash('msg') ?></h3>
        </div>
        <?php endif; ?>
        <h1 class="text-center mt-5">Profile: <strong><?= ucwords($data['user']->username); ?></strong></h1>
       <?php if (Session::get('user')->role !== 'user' || Session::get('user')-> $data['user']->id) : ?>
        <p class="text-center text-muted m-1 m-3">(<?= $data['user']->role; ?>)</p>
        <p class="text-center text-muted m-1"><?= $data['user']->active ? '(active)' : '(banned)' ?> <?= $data['user']->nsfw? '(nsfw)' : '' ?></p>
        <p class="text-center m-3"><?= $data['user']->email; ?></p>
       <?php if(Session::get('user')->id == $data['user']->id) : ?>
           <div class="d-flex justify-content-center">
                <a class="btn btn-sm btn-primary" href="../galleries/create">Create Gallery</a>
           </div>
       <?php endif; ?>
        <div class="btn-group d-flex justify-content-around m-4">
            <a class="btn btn-sm btn-warning" href="./<?= Helper::encode($data['user']->username) ?>/edit">Edit</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['galleries'])) : ?>
        <?php foreach ($data['galleries'] as $gallery) : ?>
            <div class="card m-1 border border-primary" style="width: 12rem;">
                <a href="/imgur/galleries/<?= $gallery->slug ?>">
                    <?php if($data['cover'][$gallery->id]) : ?>
                        <img class="card-img-top" src="<?= $data['cover'][$gallery->id] ?>" alt="Empty gallery">
                    <?php else: ?>
                        <img class="card-img-top" src="data:image/png;base64,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">
                    <?php endif; ?>
                </a>
                <div class="card-body">
                    <h6 class="card-title"><?= ucwords($gallery->name) ?></h6>
                    <?php if (in_array(Session::get('user')->role, ['admin', 'moderator'])) : ?>
                        <p class="text-muted"><small><?= $gallery->hidden ? '( hidden )' : '' ?><?= $gallery->nsfw ? '( nsfw )' : '' ?></small></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="row justify-content-center">
    <?php require __DIR__ . '/../includes/pagination.php'; ?>
</div>

