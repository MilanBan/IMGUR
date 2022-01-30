<?php

namespace app\controllers;

use app\adapters\PaymentAdapter;
use app\models\Helper;
use app\models\payments\CreditCard;
use app\models\Session;
use app\models\SubscriptionModel;
use app\models\UserModel;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    private SubscriptionModel $subscriptionM;
    private UserModel $userM;

    public function __construct()
    {
        $this->subscriptionM = new SubscriptionModel();
        $this->userM = new UserModel();
    }

    public function create()
    {
        $this->renderView('subscription/create');
    }

    public function history($username)
    {
        $user = $this->userM->getUser(['username', Helper::decode($username)]);
        $history = $this->subscriptionM->getSubscriptionHistory($user->id);
        $this->renderView('subscription/history', ['user' => $user, 'history' => $history]);
    }

    /**
     * @throws \Exception
     */
    public function store()
    {
        $payment = new PaymentAdapter(new CreditCard(Session::get('user')->payment));

        if (!$payment->checkPayment()){
            return $this->redirect('imgur/profiles/'.Session::get('username'));
        }

        $now = Carbon::now()->format('Y-m-d');

        $this->subscriptionM->plan = $_POST['plan'] ?? 0;

        if ($_POST['plan'] == 1){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonth();
        }elseif ($_POST['plan'] == 6){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonths(6);
        }elseif ($_POST['plan'] == 12){
            $expire = Carbon::createFromFormat("Y-m-d", $now)->addMonths(12);
        }else{
            $expire = $now;
        }

        $this->subscriptionM->subscription_expire = $expire->format("Y-m-d");

        if ($expire > $now){
            $this->subscriptionM->subscriber = true;
        }else{
            $this->subscriptionM->subscriber = false;
        }

        if ($this->subscriptionM->renewSubscribe()){
            $payment->doPayment();
        }

        $this->redirect('imgur/profiles/'.Session::get('username'));
    }
}