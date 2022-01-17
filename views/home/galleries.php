<?php

use app\models\Session;

?>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['galleries'])) : ?>
        <?php foreach ($data['galleries'] as $gallery) : ?>
            <div class="card m-1 border border-primary" style="width: 16rem;">
            <a href="/imgur/galleries/<?= $gallery->slug ?>">
                <img class="card-img-top" src="<?= $data['cover'][$gallery->id] ?>" alt="Empty gallery">
            </a>
                <div class="card-body">
                    <h5 class="card-title"><?= $gallery->name ?></h5>
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

