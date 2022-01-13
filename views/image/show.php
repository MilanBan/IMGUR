<?php
use app\models\Session;
?>
<div class="row justify-content-md-center">

<div class="card m-5" style="width: 18rem;">
    <img class="card-img-top" src="<?= $data['image']->file_name ?>" alt="Card image cap">
    <div class="card-body text-center">
        <p class="card-title">Image: <?= ucwords($data['image']->slug) ?></p>
        <p class="card-text">User: <?= ucwords($data['user']->username) ?></p>
        <p class="card-text">Gallery: <?= ucwords($data['gallery']->name) ?></p>
        <?php if (in_array(Session::get('user')->role, ['admin', 'moderator'])) : ?>
        <div class="d-flex justify-content-between">
            <p class="card-text"><small><?= $data['image']->hidden ? '(hidden)' : '' ?></small></p>
            <p class="card-text"><small><?= $data['image']->nsfw ? '(nsfw)' : '' ?></small></p>
        </div>
    </div>
    <div class="card-footer text-center">
        <div class="d-flex justify-content-between">
            <a class="btn btn-sm btn-warning" href="/imgur/galleries/images/<?= $data['image']->slug ?>/edit">Edit</a>
            <a class="btn btn-sm btn-danger" href="/nevodinigdejos">Delete</a>
        </div>
        <?php endif; ?>
    </div>
</div>

</div>
