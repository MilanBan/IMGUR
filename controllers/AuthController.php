<?php

namespace app\controllers;

use app\models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get'){
            $this->renderVidew('login');
        }

        if (isset($_POST['email']) && isset($_POST['password'])){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $userM = new UserModel('', trim($_POST['email']), trim($_POST['password']), '');

            $user = $userM->getUser('email',$userM->email);

            $this->renderVidew('home', ['user' => $user]);
        }
    }
}