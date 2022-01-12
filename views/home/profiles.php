<?php
use app\models\Session;
?>

<h1>PROFILE PAGE</h1>

<div class="d-flex flex-wrap justify-content-center">
    <?php if (isset($data['users'])) : ?>
        <?php foreach ($data['users'] as $user) : ?>
            <a href="#">
            <div class="card text-center m-5 border border-white" style="width: 12rem;">
                <img class="card-img-top rounded-circle" src="https://eu.ui-avatars.com/api/?name=<?= $user->username ?>?size=128" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $user->username ?></h5>
                    <?php if (Session::get('user')->id == $data['user']->id || in_array(Session::get('user')->role, ['moderator', 'admin'])) : ?>
                        <a class="btn btn-sm btn-warning" href="#">Edit</a>
                        <a class="btn btn-sm btn-danger" href="#">Delete</a>
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
