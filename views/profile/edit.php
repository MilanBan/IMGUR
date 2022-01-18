<?php

use app\models\Helper;
use app\models\Session;
?>

<form method="post" action="../<?= !empty(trim($_POST['username'])) ? Helper::encode(trim($_POST['username'])) : Helper::encode($data['user']->username) ?>/update">
    <?php if (Session::get('user')->id == $data['user']->id) : ?>
        <div class="form-group mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $data['user']->username ?>">
        </div>
        <?php if (isset($data['errors']['username'])) : ?>
            <div class="mb-3">
                <small class="text-danger">
                    <?= $data['errors']['username'] ?>
                </small>
            </div>
        <?php endif; ?>
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $data['user']->email ?>">
        </div>
        <?php if (isset($data['errors']['email'])) : ?>
            <div class="mb-3">
                <small class="text-danger">
                    <?= $data['errors']['email'] ?>
                </small>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (in_array(Session::get('user')->role, ['admin', 'moderator'])) : ?>
    <div class="form-check form-check-inline">
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox"
                   name="active" <?= $data['user']->active ? 'checked' : '' ?> >
            <label class="form-check-label" for="active">Active</label>
        </div>
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox"
                   name="nsfw" <?= $data['user']->nsfw ? 'checked' : '' ?> >
            <label class="form-check-label" for="nsfw">NSFW</label>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Session::get('user')->role == 'admin') : ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" value="admin" <?= $data['user']->role == 'admin' ? 'checked' : '' ?> >
            <label class="form-check-label" >
                Admin
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" value="moderator" <?= $data['user']->role == 'moderator' ? 'checked' : '' ?> >
            <label class="form-check-label" >
                Moderator
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" value="user" <?= $data['user']->role == 'user' ? 'checked' : '' ?> >
            <label class="form-check-label" >
                User
            </label>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

