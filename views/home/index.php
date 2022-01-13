<?php

use app\models\Session;

?>

    <div class="d-flex flex-wrap justify-content-center">
        <h1><?= Session::getFlash('welcome') ?></h1>
    </div>

    <div class="d-flex flex-wrap justify-content-center">
        <?php if (isset($data['images'])) : ?>
            <?php foreach ($data['images'] as $image) : ?>
                <a href="<?= Session::get('user') ? 'imgur/images/'.$image->slug : '/login' ?>">
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

