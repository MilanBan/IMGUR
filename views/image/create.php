<?php

?>

<form method="post" action="./add">
    <input type="hidden" name="gallery_slug" value="<?= $data['gallery']['slug'] ?>">
    <input type="hidden" name="gallery_id" value="<?= $data['gallery']['id'] ?>">
    <input type="hidden" name="gallery" value="<?= $data['gallery'] ?>">
    <div class="form-group mb-3">
        <label for="file_name" class="form-label">Name(url)</label>
        <input type="text" class="form-control" name="file_name">
    </div>
    <div class="form-group mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input class="form-control" name="slug">
    </div>
    <button type="submit" class="btn btn-primary">Add Image</button>
</form>

