<?php

namespace app\models;

class ModeratorLogModel extends Model
{
    public function logging()
    {
        $data = [
            'msg' => $this->msg,
            'created_at' => date("Y-m-d H:i:s")
        ];

        $sql = "INSERT INTO moderator_logging ( msg, created_at) 
                VALUES (:msg, :created_at)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

    }
}