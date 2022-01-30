<?php

namespace app\models\payments;

use app\interfaces\CreditCardInterface;
use app\models\Model;
use app\models\Session;

class CreditCard extends Model implements CreditCardInterface
{
    private $creditCard;

    public function __construct($creditCard)
    {
        parent::__construct();
        $this->creditCard = $creditCard;
    }

    public function validateCard(): bool
    {
        if ($this->creditCard){
            return true;
        }else{
            Session::setFlash('msg', "Credit Card isn't valid");
            return false;
        }
    }

    public function doPayment(): bool
    {
        if ($this->validateCard()){
            Session::setFlash('msg', "You have successfully purchased new Subscription");
            return true;
        }else{
            return false;
        }
    }
}