<?php

use app\models\Session;

?>

<div class="d-flex flex-wrap justify-content-center">
    <div class="border-bottom rounded-pill">
        <h1 class="text-center m-5">Gallery: <strong><?= ucwords($data['gallery']->name); ?></strong></h1>
        <a href="imgur/profiles/<?= $data['user']->username ?>">
            <h3 class="text-center m-3">(<?= $data['user']->username; ?>)</h3>
        </a>
        <p class="text-center m-3"><?= $data['gallery']->description; ?></p>
        <?php if (Session::get('user')->id == $data['gallery']->user_id || in_array(Session::get('user')->role, ['moderator', 'admin'])) : ?>
            <div class="btn-group d-flex justify-content-around m-5">
                <?php if (Session::get('user')->id == $data['gallery']->user_id) : ?>
                    <a class="btn btn-sm btn-success" href="imgur/galleries/<?= $data['gallery']->id ?>/images/add">Add Image</a>
                <?php endif; ?>
                <a class="btn btn-sm btn-warning" href="./<?= $data['gallery']->slug ?>/edit">Edit</a>
                <?php if (Session::get('user')->id == $data['gallery']->user_id || Session::get('user')->role != 'moderator') : ?>
                    <a class="btn btn-sm btn-danger" type="button" id="delete-gallery" data-id="<?= $data['gallery']->id ?>">Delete</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['images'])) : ?>
        <?php foreach ($data['images'] as $image) : ?>
            <a href="<?= Session::get('user') ? '' : '/login' ?>">
                <div class="card m-1" style="width: 16rem;">
                    <img class="card-img-top" src="<?= $image->file_name ?>" alt="Card image cap">
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="row justify-content-center">
    <?php require __DIR__ . '/../includes/pagination.php'; ?>
</div>

