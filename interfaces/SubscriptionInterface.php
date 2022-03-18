<?php

namespace app\interfaces;

interface SubscriptionInterface
{
    public function checkSubscription($subscription_expire, $id);

    public function renewSubscribe();

    public function setOnFree();
}