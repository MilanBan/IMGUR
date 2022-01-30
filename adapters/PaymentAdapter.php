<?php

namespace app\adapters;

use app\interfaces\CreditCardInterface;
use app\interfaces\PaymentInterface;

class PaymentAdapter implements PaymentInterface
{
    private CreditCardInterface $creditCard;

    public function __construct(CreditCardInterface $creditCard)
    {
        $this->creditCard = $creditCard;
    }

    public function checkPayment()
    {
        return $this->creditCard->validateCard();
    }

    public function doPayment()
    {
        return $this->creditCard->doPayment();
    }
}