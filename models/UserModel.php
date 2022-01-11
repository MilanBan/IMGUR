<?php

namespace app\models;

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

    public function insert()
    {
        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'user',
            'api_key' => implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6)),
        ];

        $sql = "INSERT INTO user (username, email, password, role, api_key) VALUES (:username, :email, :password, :role, :api_key)";

        $this->pdo->prepare($sql)->execute($data);

        return $this->pdo->lastInsertId();
    }


}