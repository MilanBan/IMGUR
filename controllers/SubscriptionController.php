<?php

namespace app\controllers;

use app\models\Session;
use app\models\SubscriptionModel;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    private SubscriptionModel $subscription;

    public function __construct()
    {
        $this->subscription = new SubscriptionModel();
    }

    public function create()
    {
        $this->renderView('subscription/create');
    }

    /**
     * @throws \Exception
     */
    public function store()
    {
        $now = Carbon::now()->format('Y-m-d');

        $this->subscription->plan = $_POST['plan'] ?? 0;

        if ($_POST['plan'] == 1){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonth();
        }elseif ($_POST['plan'] == 6){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonths(6);
        }elseif ($_POST['plan'] == 12){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonths(12);
        }else{
            $expire = $now;
        }

        $this->subscription->subscription_expire = $expire->format("Y-m-d");

        if ($expire > $now){
            $this->subscription->subscriber = true;
        }else{
            $this->subscription->subscriber = false;
        }

        $this->subscription->renewSubscribe();

        $this->redirect('imgur/profiles/'.Session::get('username'));
    }
}