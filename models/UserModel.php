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
}