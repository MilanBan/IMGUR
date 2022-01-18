
<div class="d-flex flex-wrap justify-content-start">
    <div class="flex-column">
        <div class="flex-column p-3 mb-5"><h2>Comments:</h2></div>
        <?php if (isset($data['comments'])) : ?>
            <?php foreach ($data['comments'] as $comment) : ?>
                <div class="d-flex shadow-lg p-3 mb-5 bg-body rounded">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <h5 class="p-3"><?= ucwords($comment->username) ?></h5>
                        <p class="m-3"><?= $comment->comment ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <form method="post" action=" <?= ($data['image']->id) ? '../../comments' : '../comments' ?>">
            <?php if ($data['image']->id) : ?>
                <input type="hidden" name="image_id" value="<?= $data['image']->id ?>">
            <?php else: ?>
                <input type="hidden" name="gallery_id" value="<?= $data['gallery']->id ?>">
            <?php endif; ?>
            <div class="d-flex shadow-lg p-3 mb-5 bg-body rounded">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3" placeholder="Leave a comment.."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
