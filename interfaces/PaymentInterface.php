<?php

namespace app\interfaces;

interface PaymentInterface
{
    public function checkPayment();

    public function doPayment();
}