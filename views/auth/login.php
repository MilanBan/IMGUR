<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">

        <div class="card-header">
            <h4 class="card-title">IMGUR</h4>
            <h6 class="card-subtitle mb-2 text-muted">Log in into the IMGUR world of photos.</h6>
        </div>
        <?php if (isset($data['errors']['user'])) : ?>
            <div class="mb-3">
                <small class="text-danger">
                    <?= $data['errors']['user'] ?>
                </small>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <form action="/login" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control <?= (isset($data['errors']['email'])) ? 'is-invalid' : (isset($data['user']->email) ? 'is-valid' : '') ?>" placeholder="Enter email" value="<?= $data['user']->email ?? '' ?>">
                </div>
                <?php if (isset($data['errors']['email'])) : ?>
                    <div class="mb-3">
                        <small class="text-danger">
                            <?= $data['errors']['email'] ?>
                        </small>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="password" name="password" class="form-control <?= !isset($data['errors']['password']) ? '' : 'is-invalid' ?>" placeholder="Enter Password" >
                </div>
                <?php if (isset($data['errors']['password'])) : ?>
                    <div class="mb-3">
                        <small class="text-danger">
                            <?= $data['errors']['password'] ?>
                        </small>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Log In</button>
                </div>
            </form>
        </div>

        <div class="card-footer text-muted">
            <a href="/register" ><small>Don't have an account?</small></a>
        </div>
    </div>
</div>