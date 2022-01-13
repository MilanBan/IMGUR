<?php
use app\models\Session;
?>
<div class="row justify-content-md-center">

<div class="card m-5" style="width: 18rem;">
    <img class="card-img-top" src="<?= $data['image']->file_name ?>" alt="Card image cap">
    <div class="card-body">
        <p class="card-text">Image: <?= ucwords($data['image']->slug) ?></p>
        <p class="card-text">User: <?= ucwords($data['user']->username) ?></p>
        <p class="card-text">Gallery: <?= ucwords($data['gallery']->name) ?></p>
    </div>
    <?php if (in_array(Session::get('user')->role, ['admin', 'moderator'])) : ?>
    <div class="card-footer text-center">
        <div class="d-flex justify-content-between">
            <a class="btn btn-sm btn-warning" href="#">Edit</a>
            <a class="btn btn-sm btn-danger" href="#">Delete</a>
        </div>
    </div>
    <?php endif; ?>
</div>

</div>
