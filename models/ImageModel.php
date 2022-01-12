<?php

namespace app\models;

class ImageModel extends Model
{
    public function getAll($start, $prePage)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){
            $sql = sprintf("SELECT `slug`, `file_name` FROM `image` LIMIT %s, %s",
                $start,
                $prePage
            );
        }else{
            $sql = sprintf("SELECT `slug`, `file_name` FROM `image` WHERE `hidden` = 0 AND `nsfw` = 0 LIMIT %s, %s",
                $start,
                $prePage
            );
        }

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getAllByGallery($gallery_id,$start,$prePage)
    {
        $sql = sprintf("SELECT i.`slug`, i.`file_name` FROM `image` i INNER JOIN `image_gallery` ig ON i.`id` = ig.`image_id` WHERE ig.`gallery_id` = %s ORDER BY i.`id` DESC LIMIT %s, %s",
            $gallery_id,
            $start,
            $prePage
        );

        return $this->pdo->query($sql)->fetchAll();
    }


// helper
    public function getTotal($gallery_id = null)
    {
        if ($gallery_id){
            $user_id = $this->pdo->query("SELECT `user_id` FROM `gallery` WHERE `id` = $gallery_id")->fetchColumn();
        }
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {
            $sql = "SELECT count(*) as 'total' FROM image";
        }elseif (Session::get('user')->id == $user_id){
            $sql = sprintf("SELECT count(*) as 'total' FROM image WHERE `user_id` = %s `hidden` = 0 AND `nsfw` = 0",
                Session::get('user')->id
                );
        }else{
            $sql = "SELECT count(*) as 'total' FROM image WHERE `hidden` = 0 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

}