<?php

namespace app\controllers;

use app\models\Session;
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
        $user = $this->userM->getUser(['id', Session::get('user')->id]);

        $this->renderView('home', ['user' => $user]);
    }
}