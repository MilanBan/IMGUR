<?php

use app\models\Session;
$i = 0;
$plan = [
    0 => 'free',
    1 => '1 month',
    6 => '6 months',
    12 => '12 months'
];
?>
<div class="d-flex justify-content-center mt-5 ">
    <div class="card text-center">
        <div class="card-header">
            <h4 class="card-title"><?= ucwords($data['user']->username) ?>'s Subscription History</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Active</th>
                    <th scope="col">Expire</th>
                    <th scope="col">On Hold</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($data['history']): ?>
                <?php foreach ($data['history'] as $history): ?>
                <?php $i++ ?>
                    <tr class="<?= $history->subscriber ? 'table-success' : ''?>" >
                        <th scope="row"><?= $i ?></th>
                        <td><?= $plan[$history->plan] ?></td>
                        <td><?= $history->subscriber ? 'Yes' : 'No' ?></td>
                        <td><?= $history->subscription_expire ?></td>
                        <td><?= $history->hold ? 'Yes' : 'No' ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            <?php if($data['user']->id == Session::get('user')->id):?>
            <a class="btn btn-sm btn-primary" href="/imgur/profiles/<?= Session::get('username') ?>/subscription/"><?= Session::get('subs') == 'free' ? 'Buy now' : 'Renew Subscription'?></a>
            <?php endif; ?>
        </div>
    </div>
</div>