<?php
use app\models\Session;
?>

<form method="post" action="../<?= $data['gallery']->slug ?>/update">
    <?php if (Session::get('user')->id == $data['gallery']->user_id || Session::get('user')->role == 'admin') : ?>
        <div class="form-group mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?= $data['gallery']->name ?>">
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description"><?= $data['gallery']->description ?></textarea>
        </div>
    <?php endif; ?>
    <div class="form-check form-check-inline">
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox"
                   name="hidden" <?= ($data['gallery']->hidden ? 'checked' : '') ?> >
            <label class="form-check-label" for="hidden">Hidden</label>
        </div>
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox"
                   name="nsfw" <?= ($data['gallery']->nsfw ? 'checked' : '') ?> >
            <label class="form-check-label" for="nsfw">NSFW</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

