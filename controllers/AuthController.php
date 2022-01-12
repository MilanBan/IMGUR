<?php

namespace app\controllers;

use app\models\Session;
use app\models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get'){
            $this->renderView('auth/login');
        }

        if (isset($_POST['email']) && isset($_POST['password'])){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $userM = new UserModel('', trim($_POST['email']), trim($_POST['password']), '');
            $errors = $userM->validate('login');

            if (count($errors)){
                http_response_code(422);
                $this->renderView('auth/login', ['errors' => $errors, 'user' => $userM]);
            }else{
                $user = $userM->getUser(['email', $userM->email]);
                Session::set('user', $user);
                $this->redirect('imgur');
            }
        }
    }

    public function register()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get'){
            $this->renderView('auth/register');
        }

        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userM = new UserModel(trim($_POST['username']), trim($_POST['email']), trim($_POST['password']), trim($_POST['confirm_password']));
            $errors = $userM->validate('register');

            if (count($errors)){
                http_response_code(422);
                $this->renderView('auth/register', ['errors' => $errors, 'user' => $userM]);
            }else{
                $userID = $userM->insert();
                $user = $userM->getUser(['id', $userID]);
                Session::set('user', $user);
                $this->redirect('imgur');
            }
        }
    }

    public function logout()
    {
        $userM = new UserModel();
        $userM->deleteSession();
        $this->redirect('imgur');
    }
}