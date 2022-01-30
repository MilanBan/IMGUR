<?php

use app\models\Session;

?>
<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">
        <div class="card-header">
            <h4 class="card-title">IMGUR</h4>
            <h6 class="card-subtitle mb-2 text-muted"><?= (Session::get('subs') == 'free') ? 'Be A Subscriber' : 'Renew Your Subscription'?><?= Session::get('expire') ? "(".Session::get('expire')." left)" : '' ?></h6>
        </div>

        <form action="./subscription" method="post">
            <div class="card-body">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="plan" value="1" checked>
                    <label class="form-check-label" >
                        1 Month (20 uploads/month)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="plan" value="6">
                    <label class="form-check-label" >
                        6 Months (30 uploads/month)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="plan" value="12">
                    <label class="form-check-label" >
                        12 Months (50 uploads/month)
                    </label>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="/imgur/profiles/<?= \app\models\Session::get('username') ?>" class="btn btn-sm btn-warning">Cancel <small>(stay on 5 uploads/month)</small></a>
                <button type="submit" class="btn btn-sm btn-success">Subscribe</button>
            </div>
        </form>
    </div>
</div>