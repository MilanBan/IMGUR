<?php

namespace app\models;

class UserModel extends Model
{
    public function getUser()
    {
        return $this->pdo->query("SELECT * FROM user WHERE id = 1")->fetch();
    }
}