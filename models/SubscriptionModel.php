<?php

namespace app\models;

use app\interfaces\SubscriptionInterface;
use Carbon\Carbon;

class SubscriptionModel extends Model implements SubscriptionInterface
{
    public int $user_id;
    public $plan;
    public $subscriber;
    public $subscription_expire;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->user_id = Session::get('user')->id;
        $this->plan = 0;
        $this->subscriber = 0;
        $this->subscription_expire = Carbon::now()->format('Y-m-d');
    }

    public function getSubscriptionHistory($user_id)
    {
        $sql = "SELECT * FROM `subscription` WHERE `user_id` = $user_id ORDER BY `id`";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getCurrentPlan($user_id)
    {
        $sql = "SELECT * FROM `subscription` WHERE `user_id` = $user_id AND `hold` = 0 ORDER BY `id` DESC LIMIT 1";

        return $this->pdo->query($sql)->fetch();
    }

    public function getOnHoldPlan($user_id)
    {
        $sql = "SELECT * FROM `subscription` WHERE `user_id` = $user_id AND `hold` = 1";

        return $this->pdo->query($sql)->fetch();
    }

    public function setOnFree()
    {
        $data = [
            'user_id' => Session::get('user')->id,
            'plan' => 0,
            'subscriber' => 0,
            'subscription_expire' => Carbon::now()->format("Y-m-d")
        ];

        Session::set('subs', 'free');
        $this->pdo->prepare("INSERT INTO `subscription` (user_id, plan, subscriber, subscription_expire) VALUES (:user_id, :plan, :subscriber, :subscription_expire)")->execute($data);
    }

    public function checkSubscription($subscription_expire, $id): bool
    {
        if($subscription_expire < Carbon::now()->format("Y-m-d")){
            $this->pdo->prepare("UPDATE `subscription` SET `subscriber` = 0 WHERE `id` = $id")->execute();
            $sql = sprintf("SELECT * FROM `subscription` WHERE `user_id` = %s AND `hold` = 1", Session::get('user')->id);
            $next = $this->pdo->query($sql)->fetch();
            if ($next){
                $this->pdo->prepare("UPDATE `subscription` SET `subscriber` = 1, `hold` = 0 WHERE `id` = $next->id")->execute();
                $subscription_expire = Carbon::createFromFormat("Y-m-d",$next->subscription_expire);
                $diff = $subscription_expire->diffInDays(Carbon::now());
                Session::set('expire', "$diff days");
                $plan = [
                    0 => 'free',
                    1 => '1 month',
                    6 => '6 months',
                    12 => '12 months'
                ];
                Session::set('subs', $plan[$next->plan]);
                Session::set('sub-data', ['months' => $next->plan, 'expire' => $next->subscription_expire]);

            }else{
                $this->setOnFree();
            }

            return false;
        }else{
            $expire = Carbon::createFromFormat("Y-m-d",$subscription_expire);
            $diff = $expire->diffInDays(Carbon::now());
            Session::set('expire', "$diff days");
            return true;
        }
    }

    public function renewSubscribe()
    {
        $last_sub = $this->pdo->query("SELECT * FROM subscription WHERE user_id = $this->user_id AND hold = 0 ORDER BY id DESC LIMIT 1")->fetch();
        $sql = '';
        $data = [
            'user_id' => $this->user_id,
            'plan' => $this->plan,
            'subscriber' => $this->subscriber,
            'subscription_expire' => $this->subscription_expire
        ];

        if ($last_sub->plan == 0){ // free

            $subscription_expire = Carbon::createFromFormat("Y-m-d",$this->subscription_expire);
            $diff = $subscription_expire->diffInDays(Carbon::now());
            $plan = [
                0 => 'free',
                1 => '1 month',
                6 => '6 months',
                12 => '12 months'
            ];

            Session::set('subs', $plan[$data['plan']]);
            Session::set('expire', "$diff days");
            $sql = "UPDATE subscription SET plan=:plan, subscriber=:subscriber ,subscription_expire=:subscription_expire WHERE user_id = :user_id";
        }else{ // nije bio free
            if ($last_sub->subscriber){ // aktivan je
                $subscription_expire = Carbon::createFromFormat("Y-m-d",$last_sub->subscription_expire);
                $diff = $subscription_expire->diffInDays(Carbon::now());

                if ($diff>0)
                {
                    if ($last_sub->plan < $this->plan){ // prelazak na veci plan
                        $this->pdo->prepare($sql = "UPDATE subscription SET subscriber = 0 WHERE id = $last_sub->id")->execute();
                        $sql = "INSERT INTO subscription (user_id, plan, subscriber, subscription_expire) VALUES (:user_id, :plan, :subscriber, :subscription_expire)";

                        $new_subscription_expire = Carbon::createFromFormat("Y-m-d", $this->subscription_expire)->addDays($diff);
                        $data['subscription_expire'] = $new_subscription_expire->format("Y-m-d");

                        $diff = $new_subscription_expire->diffInDays(Carbon::now());
                        $plan = [
                            0 => 'free',
                            1 => '1 month',
                            6 => '6 months',
                            12 => '12 months'
                        ];

                        Session::set('subs', $plan[$this->plan]);
                        Session::set('sub-data', ['months' => $this->plan, 'expire' => $this->subscription_expire]);
                        Session::set('expire', "$diff days");
                    }else{ // na manji

                        if ($this->getOnHoldPlan(Session::get('user')->id)){ // ogranicava na samo jednu pretplatu unapred
                            Session::setFlash('msg','You already have the next subscription purchased');
                            return;
                        }
                        // insertuje novi plan i stavlja ga na cekanje
                        $new_subscription_expire = Carbon::createFromFormat("Y-m-d", $this->subscription_expire)->addDays($diff);
                        $data['subscription_expire'] = $new_subscription_expire->format("Y-m-d");
                        $data['subscriber'] = 0;
                        $data['hold'] = 1;
                        $plan = [
                            0 => 'free',
                            1 => '1 month',
                            6 => '6 months',
                            12 => '12 months'
                        ];

                        Session::set('subs', $plan[$last_sub->plan]);
                        Session::set('sub-data', ['months' => $last_sub->plan, 'expire' => $last_sub->subscription_expire]);
                        Session::set('expire', "$diff days");

                        $sql = "INSERT INTO subscription (user_id, plan, subscriber, subscription_expire, hold) VALUES (:user_id, :plan, :subscriber, :subscription_expire, :hold)";
                    }

                }
            }else{ // ako je istekao
                $sql = "INSERT INTO subscription (user_id, plan, subscriber, subscription_expire) VALUES (:user_id, :plan, :subscriber, :subscription_expire)";

                $subscription_expire = Carbon::createFromFormat("Y-m-d",$this->subscription_expire);
                $diff = $subscription_expire->diffInDays(Carbon::now());

                $plan = [
                    0 => 'free',
                    1 => '1 month',
                    6 => '6 months',
                    12 => '12 months'
                ];

                Session::set('subs', $plan[$this->plan]);
                Session::set('sub-data', ['months' => $this->plan, 'expire' => $this->subscription_expire]);
                Session::set('expire', "$diff days");
            }
        }
        try {
            $this->pdo->prepare($sql)->execute($data);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }
}