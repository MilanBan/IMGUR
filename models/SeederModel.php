<?php

namespace app\models;

use Carbon\Carbon;

class SeederModel extends Model
{
    private UserModel $userM;

    public function __construct()
    {
        parent::__construct();

        $this->userM = new UserModel();
    }

    public function seedFreeSubsForAllUsers()
    {
        // seed default subscription plan (free)
        $sql = "SELECT id FROM `user` ORDER BY id";
        $ids = $this->pdo->query($sql)->fetchAll();
        $data = [
            'user_id' => 0,
            'plan' => 0,
            'subscriber' => 0,
            'subscription_expire' => Carbon::now()->format("Y-m-d")
        ];
        foreach ($ids as $id){
            $data['user_id'] = $id->id;
            $this->pdo->prepare("INSERT INTO `subscription` (user_id, plan, subscriber, subscription_expire) VALUES (:user_id, :plan, :subscriber, :subscription_expire)")->execute($data);
        }

        // seed in every image created_at (2021-01-15)
        $this->pdo->prepare("UPDATE image SET created_at='2021-01-15'")->execute();
    }
}