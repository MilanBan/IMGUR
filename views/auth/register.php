<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">

        <div class="card-header">
            <h4 class="card-title">IMGUR</h4>
            <h6 class="card-subtitle mb-2 text-muted">Sign up to see photos from your friends.</h6>
        </div>

        <div class="card-body">
            <form action="/register" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control <?= (isset($data['errors']['username'])) ? 'is-invalid' : (isset($data['user']->username) ? 'is-valid' : '') ?>" placeholder="Enter Username" value="<?= $data['user']->username ?? '' ?>">
                </div>
                <?php if (isset($data['errors']['username'])) : ?>
                    <div class="mb-3">
                        <small class="text-danger">
                            <?= $data['errors']['username'] ?>
                        </small>
                    </div>
                <?php endif; ?>
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
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control <?= !isset($data['errors']['confirm_password']) ? '' : 'is-invalid' ?>" placeholder="Confirm Password">
                </div>
                <?php if (isset($data['errors']['confirm_password'])) : ?>
                    <div class="mb-3">
                        <small class="text-danger">
                            <?= $data['errors']['confirm_password'] ?>
                        </small>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
        </div>

        <div class="card-footer text-muted">
            <a href="/login" ><small>Already have as account?</small></a>
        </div>
    </div>
</div>