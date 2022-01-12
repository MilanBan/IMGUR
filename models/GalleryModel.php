<?php

namespace app\models;

class GalleryModel extends Model
{
    public function getAll($start, $prePage)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){
            $sql = sprintf("SELECT * FROM `gallery` LIMIT %s, %s",
                $start,
                $prePage
            );
        }else{
            $sql = sprintf("SELECT * FROM `gallery` WHERE `hidden` = 0 AND `nsfw` = 0 LIMIT %s, %s",
                $start,
                $prePage
            );
        }

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getTotal()
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {
            $sql = "SELECT count(*) as 'total' FROM gallery";
        }else{
            $sql = "SELECT count(*) as 'total' FROM gallery WHERE `hidden` = 0 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

    public function getCover($id)
    {
        $sql = "SELECT i.`file_name` FROM `image` i INNER JOIN `image_gallery` ig ON i.`id` = ig.`image_id` WHERE ig.`gallery_id` = '$id' ORDER BY i.`id` DESC LIMIT 1";

        return $this->pdo->query($sql)->fetchColumn();
    }
}