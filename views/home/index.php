<?php

use app\models\Session;

?>



<div class="d-flex flex-wrap justify-content-center">
    <h1><?= Session::getFlash('welcome') ?></h1>
</div>
    <div class="d-flex flex-wrap justify-content-center">
        <?php if (isset($data['images'])) : ?>
            <?php foreach ($data['images'] as $image) : ?>
                <div class="m-3 align-self-center">
                    <div class="d-flex m-3">
                        <?php if (Session::get('user')) : ?>
                            <a class="mx-auto" href="http://localhost:8080/images/<?= $image->slug ?> ">
                        <?php else: ?>
                            <a class="mx-auto" href="/login">
                        <?php endif; ?>
                                <img class="img-fluid rounded" src="<?= $image->file_name ?>">
                            </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="row justify-content-center">

    <?php require __DIR__ . '/../includes/pagination.php'; ?>
    </div>

