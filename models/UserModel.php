<?php

namespace app\models;

use Carbon\Carbon;

class UserModel extends Model
{
    public string $username;
    public string $email;
    public string $password;
    public string $confirm_password;

    public function __construct($username = '', $email = '', $password = '', $confirm_password = '')
    {
        parent::__construct();
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
    }

    public function getUser($params)
    {

        $sql = sprintf("SELECT * FROM user WHERE %s = '%s'",
            $params[0],
            $params[1],
        );

        return $this->pdo->query($sql)->fetch();
    }

    public function getAll($start, $prePage, $page)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator']))
        {
            if (Redis::exists("a:site:profiles:$page"))
            {
                var_dump('all users from redis');
                return Redis::cached("a:site:profiles:$page");

            }else{
                $sql = sprintf("SELECT * FROM `user` LIMIT %s, %s",
                    $start,
                    $prePage
                );

                $results = $this->pdo->query($sql)->fetchAll();

                Redis::caching("a:site:profiles:$page", $results);
                var_dump('all users from db');

                return $results;

            }
        }else{
            if (Redis::exists("u:site:profiles:$page"))
            {
                return Redis::cached("u:site:profiles:$page");

            }else{
                $sql = sprintf("SELECT * FROM `user` WHERE `active` = 1 AND `nsfw` = 0 LIMIT %s, %s",
                    $start,
                    $prePage
                );

                $results = $this->pdo->query($sql)->fetchAll();

                Redis::caching("u:site:profiles:$page", $results);

                return $results;
            }
        }
    }

    public function insert()
    {
        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'role' => 'user',
            'api_key' => implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6)),
        ];

        $sql = "INSERT INTO user (username, email, password, role, api_key) VALUES (:username, :email, :password, :role, :api_key)";

        $this->pdo->prepare($sql)->execute($data);
        Redis::remove("*:site:profiles:*");

        return $this->pdo->lastInsertId();
    }

    public function update($id)
    {
        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'active' => $this->active,
            'nsfw' => $this->nsfw,
            'role' => $this->role,
            'id' => $id
        ];

        $sql = "UPDATE user SET username = :username, email = :email, active = :active, nsfw = :nsfw, role = :role WHERE id=:id";

        try {
            $this->pdo->prepare($sql)->execute($data);
            return true;
        }catch (\PDOException $e){
            return false;
        }
    }

    public function getTotal()
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {             // Site - profiles
            $sql = "SELECT count(*) as 'total' FROM user";
        }else{                                                                          // Site - profiles
            $sql = "SELECT count(*) as 'total' FROM user WHERE `active` = 1 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

    public function validate($mode = []): array
    {
        $this->errors = [];
        $this->mode = $mode;

        if ($mode === 'update'){
            if (!empty(trim($_POST['username']))){
                $this->validateUsername();
            }
            if (!empty(trim($_POST['email']))){
                $this->validateEmail();
            }
        }
        if (in_array($mode, ['register' , 'login'])){
            $this->validateEmail();
            $this->validatePassword();
        }

        if ($mode === 'register') {
            $this->validateUsername();
            $this->validateEmailExist();
            $this->validatePasswordMatching();
        }
        if ($mode === 'login') {
            $this->validateUserExist();
        }

        return $this->errors;
    }

    private function validateUsername()
    {
        if (empty($this->username)){
            $this->errors['username'] = 'Username is required';
        }
        if(strlen($this->username) < 2){
            $this->errors['username'] =  'Username must contain at least 2 characters';
        }
        if ($this->pdo->query("SELECT `username` FROM `user` WHERE `username` = '$this->username'")->rowCount()){
            $this->errors['username'] = 'A user with this Username already exists';
        }
    }

    private function validateEmail()
    {
        if (empty($this->email)){
            $this->errors['email'] = 'Email is required';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not valid';
        }
    }

    private function validateEmailExist()
    {
        if ($this->pdo->query("SELECT `email` FROM `user` WHERE `email` = '$this->email'")->rowCount()) {
            $this->errors['email'] = "User with $this->email email address is already registered";
        }
    }

    private function validateUserExist()
    {
        if ($this->pdo->query("SELECT `email`,`password` FROM `user` WHERE `email` = '$this->email' AND `password` = '$this->password'")->fetch()) {
            $this->errors['user'] = "User with $this->email email does not exists";
        }
    }

    private function validatePassword()
    {
        if (empty($this->password)){
            $this->errors['password'] = 'Password is required';
        }
        if(strlen($this->password) < 8){
            $this->errors['password'] = 'Password must be at least 8 characters long';
        }
    }

    private function validatePasswordMatching()
    {
        if (empty($this->confirm_password)){
            $this->errors['$this->confirm_password'] = 'Password confirming is required';
        }
        if ($this->confirm_password !== $this->password){
            $this->errors['$this->confirm_password'] = 'Password did not match. Please try again.';
        }
    }
}