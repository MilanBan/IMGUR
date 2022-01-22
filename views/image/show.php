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
                <div>
                    <?php Session::set('gallery_slug', $data['gallery']->slug); ?>
                    <a class="btn btn-sm btn-warning" href="/imgur/galleries/images/<?= $data['image']->slug ?>/edit">Edit</a>
                </div>
                <form id="form" method="post" action="/imgur/galleries/images/<?= $data['image']->id ?>">
                    <input type="hidden" name="gallery_slug" value="<?= $data['gallery']->slug ?>" >
                    <button class="btn btn-sm btn-danger" type="submit" >Delete</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <?php require __DIR__.'/../includes/comments.php'; ?>
</div>


