<?php

namespace app\models;

class ImageModel extends Model
{
    public function getAll($start, $prePage)
    {
        $sql = sprintf("SELECT * FROM `image` WHERE `hidden` = 0 AND `nsfw` = 0 LIMIT %s, %s",
            $start,
            $prePage
        );

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getTotal()
    {
        $sql = "SELECT count(*) as 'total' FROM image";

        return $this->pdo->query($sql)->fetch();
    }

}