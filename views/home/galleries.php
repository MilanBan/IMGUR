<?php

use app\models\Session;

?>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['galleries'])) : ?>
        <?php foreach ($data['galleries'] as $gallery) : ?>
            <a href="#">
            <div class="card m-1 border border-primary" style="width: 16rem;">
                <img class="card-img-top" src="<?= $data['cover'][$gallery->id] ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $gallery->name ?></h5>
                </div>
            </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="row justify-content-center">
    <?php require __DIR__ . '/../includes/pagination.php'; ?>
</div>

