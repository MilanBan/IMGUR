<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">

        <div class="card-header">
            <h4 class="card-title">IMGUR</h4>
            <h6 class="card-subtitle mb-2 text-muted">Sign up to see photos from your friends.</h6>
        </div>

        <div class="card-body">
            <form action="/register" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" >
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
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