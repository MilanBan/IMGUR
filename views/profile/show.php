<?php

use app\models\Session;

?>

<div class="d-flex flex-wrap justify-content-center">
    <div class="border-bottom rounded-pill">
        <h1 class="text-center mt-5">Profile: <strong><?= ucwords($data['user']->username); ?></strong></h1>
       <?php if (Session::get('user')->role !== 'user') : ?>
        <p class="text-center m-3">(<?= $data['user']->role; ?>)</p>
        <p class="text-center m-3"><?= $data['user']->email; ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['galleries'])) : ?>
        <?php foreach ($data['galleries'] as $gallery) : ?>
            <div class="card m-1 border border-primary" style="width: 12rem;">
                <a href="/imgur/galleries/<?= $gallery->slug ?>">
                    <img class="card-img-top" src="<?= $data['cover'][$gallery->id] ?>" alt="Card image cap">
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

