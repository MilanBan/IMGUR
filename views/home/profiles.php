<?php

use app\models\Helper;
use app\models\Session;
?>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['users'])) : ?>
        <?php foreach ($data['users'] as $user) : ?>
            <a href="/imgur/profiles/<?= Helper::encode($user->username) ?>">
            <div class="card text-center m-5 border border-white" style="width: 12rem;">
                <img class="card-img-top rounded-circle" src="https://eu.ui-avatars.com/api/?name=<?= $user->username ?>?size=128" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $user->username ?></h5>
                    <?php if (Session::get('user')->id == $user->id || in_array(Session::get('user')->role, ['moderator', 'admin'])) : ?>
                        <a class="btn btn-sm btn-warning" href="/imgur/profiles/<?= Helper::encode($user->username) ?>/edit">Edit</a>
                    <?php endif ?>
                </div>
            </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="row justify-content-center">

    <?php require __DIR__ . '/../includes/pagination.php'; ?>
</div>
