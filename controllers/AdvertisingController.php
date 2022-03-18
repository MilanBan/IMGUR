<?php

namespace app\controllers;

use app\models\Advertising;

class AdvertisingController extends Controller
{
    private Advertising $advertising;

    public function __construct()
    {
        $this->advertising = new Advertising();
    }

    public function countClicks($name, $banner_id = 0)
    {
        $this->advertising->countClicks($name, $banner_id);
        $this->redirect('/imgur'); // not redirect jet
    }
}