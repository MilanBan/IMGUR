<?php

namespace app\controllers;

use app\models\Helper;
use app\models\Session;
use app\models\SubscriptionModel;
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
                Session::set('username', Helper::encode($user->username));

                $subM = new SubscriptionModel();
                $sub = $subM->getCurrentPlan($user->id); // poslednji koji nije na hold-u

                if ($sub->plan == 0){ // ako je free, redirekt na kupovinu pretplate

                    if (!$sub->id){
                        $subM->setOnFree();
                    }

                    Session::set('subs', 'free');
                    return $this->redirect('imgur/profiles/' . Session::get('username') . '/subscription');
                }

                if (!$subM->checkSubscription($sub->subscription_expire, $sub->id)) { //ako ima pretplatu ali je istekla
                    Session::set('subs', 'free');
                    return $this->redirect('imgur/profiles/' . Session::get('username') . '/subscription');
                }

                $plan = [
                    0 => 'free',
                    1 => '1 month',
                    6 => '6 months',
                    12 => '12 months'
                ];

                Session::set('subs', $plan[$sub->plan]); // ako je pretplata vazeca
                Session::setFlash('welcome', '<small>Welcome back</small> '.$user->username);
                $this->redirect('imgur/profiles/'.Session::get('username'));
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
                Session::set('username', Helper::encode($user->username));
                Session::setFlash('welcome', '<small>Welcome</small> '.$user->username);

                $subM = new SubscriptionModel();
                $subM->setOnFree();
                Session::set('subs', 'free');

                $this->redirect('imgur/profiles/' . Session::get('username') . '/subscription');
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