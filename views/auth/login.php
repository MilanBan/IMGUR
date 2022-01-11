<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">

        <div class="card-header">
            <h4 class="card-title">IMGUR</h4>
            <h6 class="card-subtitle mb-2 text-muted">Log in into the IMGUR world of photos.</h6>
        </div>

        <div class="card-body">
            <form action="/login" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
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