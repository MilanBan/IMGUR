<?php

namespace app\interfaces;

interface SubscriptionInterface
{
    public function checkSubscription();

    public function renewSubscribe();

    public function setOnFree();
}