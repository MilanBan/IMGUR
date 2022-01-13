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

    public function find($slug)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){
            $sql = sprintf("SELECT * FROM `gallery` WHERE `slug` = '%s'",
                $slug
            );
        }else{
            $sql = sprintf("SELECT * FROM `gallery` WHERE `slug` = '%s' AND `hidden` = 0 AND `nsfw` = 0",
                $slug
            );
        }

        return $this->pdo->query($sql)->fetch();
    }


//helper
    public function getTotal()
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){              // Site - galleries
            $sql = "SELECT count(*) as 'total' FROM gallery";
        }else{                                                                          // Site - galleries
            $sql = "SELECT count(*) as 'total' FROM gallery WHERE `hidden` = 0 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

    public function getCover($id)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {
            $sql = "SELECT i.`file_name` FROM `image` i INNER JOIN `image_gallery` ig ON i.`id` = ig.`image_id` WHERE ig.`gallery_id` = '$id' ORDER BY i.`id` DESC LIMIT 1";
        }else{
            $sql = "SELECT i.`file_name` FROM `image` i INNER JOIN `image_gallery` ig ON i.`id` = ig.`image_id` WHERE ig.`gallery_id` = '$id' AND i.`hidden` = 0 AND i.`nsfw` = 0 ORDER BY i.`id` DESC LIMIT 1";
        }

        return $this->pdo->query($sql)->fetchColumn();
    }

    public function update($id)
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'hidden' => $this->hidden,
            'nsfw' => $this->nsfw,
            'id' => $id
        ];

        $sql = "UPDATE gallery SET name=:name, description=:description, hidden=:hidden, nsfw=:nsfw WHERE id=:id";

        try {
            $this->pdo->prepare($sql)->execute($data);
            return true;
        }catch (\PDOException $e){
            return false;
        }
    }
}