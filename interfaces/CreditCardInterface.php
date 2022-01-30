<?php

namespace app\interfaces;

interface CreditCardInterface
{
    public function validateCard();

    public function doPayment();
}