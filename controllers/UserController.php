<?php

namespace app\controllers;

use app\models\UserModel;

class UserController extends Controller
{

    private UserModel $userM;

    public function __construct()
    {
        $this->userM = new UserModel();
    }

    public function user()
    {
        $user = $this->userM->getUser();

        $this->renderVidew('home', ['user' => $user]);
    }
}