<?php

namespace app\models;

class GalleryModel extends Model
{
    public function getAll($start, $prePage)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){
            $sql = sprintf("SELECT * FROM `gallery` ORDER BY `id` DESC LIMIT %s, %s",
                $start,
                $prePage
            );
        }else{
            $sql = sprintf("SELECT * FROM `gallery` WHERE `hidden` = 0 AND `nsfw` = 0 ORDER BY `id` DESC  LIMIT %s, %s",
                $start,
                $prePage
            );
        }

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getGallery($params)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])){
            $sql = sprintf("SELECT * FROM `gallery` WHERE `%s` = '%s'",
                $params[0],
                $params[1]
            );
        }else{
            $sql = sprintf("SELECT * FROM `gallery` WHERE `%s` = '%s' AND `hidden` = 0 AND `nsfw` = 0",
                $params[0],
                $params[1]
            );
        }

        return $this->pdo->query($sql)->fetch();
    }


//helper
    public function getTotal($user_id = null)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator']) && $user_id == null) {              // Site - galleries
            $sql = "SELECT count(*) as 'total' FROM gallery";
        }elseif ($user_id !== null){
            $sql = "SELECT count(*) as 'total' FROM gallery WHERE user_id = $user_id";
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

    public function getGalleryByImage($id)
    {
        $sql = "SELECT g.`name`, g.`slug` FROM `gallery` g INNER JOIN `image_gallery` ig ON g.`id` = ig.`gallery_id` WHERE ig.`image_id` = $id";

        return $this->pdo->query($sql)->fetch();
    }

    public function delete()
    {
        var_dump('delete');
    }

    public function getGalleriesForUser($id, $start, $prePage)
    {
        $sql = sprintf("SELECT * FROM gallery WHERE user_id = %s ORDER BY id DESC LIMIT %s, %s",
            $id,
            $start,
            $prePage
        );

        return $this->pdo->query($sql)->fetchAll();
    }

    public function insert()
    {
        $data = [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
        ];

        $sql = "INSERT INTO gallery (user_id, name, description, slug) 
                VALUES (:user_id, :name, :description, :slug)";

        try {
           $this->pdo->prepare($sql)->execute($data);
        }catch (\PDOException $e){
            return false;
        }
    }
}