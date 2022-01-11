<?php

namespace app\controllers;

use app\models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get'){
            $this->renderVidew('auth/login');
        }

        if (isset($_POST['email']) && isset($_POST['password'])){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $userM = new UserModel('', trim($_POST['email']), trim($_POST['password']), '');
            $errors = $userM->validate('login');

            if (count($errors)){
                http_response_code(422);
                $this->renderVidew('auth/login', ['errors' => $errors, 'user' => $userM]);
            }

            $user = $userM->getUser(['email', $userM->email]);

            $this->renderVidew('home', ['user' => $user]);
        }
    }

    public function register()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get'){
            $this->renderVidew('auth/register');
        }

        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userM = new UserModel(trim($_POST['username']), trim($_POST['email']), trim($_POST['password']), trim($_POST['confirm_password']));
            $errors = $userM->validate('register');

            if (count($errors)){
                http_response_code(422);
                $this->renderVidew('auth/register', ['errors' => $errors, 'user' => $userM]);
            }else{
                $userID = $userM->insert();
                $user = $userM->getUser(['id', $userID]);
                $this->renderVidew('home', ['user' => $user]);
            }
        }
    }
}