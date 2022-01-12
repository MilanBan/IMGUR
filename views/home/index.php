<?php

use app\models\Session;

?>




<h1> Welcome d <?= $data['user']->username ?> </h1>
<h1> Welcome s <?= \app\models\Session::get('user')->username ?> </h1>

    <div class="d-flex flex-wrap justify-content-center">
        <?php if (isset($data['images'])) : ?>
            <?php foreach ($data['images'] as $image) : ?>
                <div class="d-flex flex-column">
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

