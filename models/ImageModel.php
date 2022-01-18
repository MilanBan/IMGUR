<?php

namespace app\models;

class ImageModel extends Model
{
    public function getAll($start, $prePage)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {
            $sql = sprintf("SELECT `slug`, `file_name` FROM `image` LIMIT %s, %s",
                $start,
                $prePage
            );
        } else {
            $sql = sprintf("SELECT `slug`, `file_name` FROM `image` WHERE `hidden` = 0 AND `nsfw` = 0 LIMIT %s, %s",
                $start,
                $prePage
            );
        }

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getAllByGallery($gallery_id, $start, $prePage)
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
        if (in_array(Session::get('user')->role, ['admin', 'moderator'])) {             // Site - index
            $sql = "SELECT count(*) as 'total' FROM image";
        }
        if ($gallery_id) {                                                              // Gallery - show
            $sql = sprintf("SELECT count(*) as 'total' FROM `image_gallery` WHERE gallery_id = %s",
                $gallery_id
            );
        } else {                                                                           // Site - index
            $sql = "SELECT count(*) as 'total' FROM image WHERE `hidden` = 0 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

    public function getImage($params)
    {
        $sql = sprintf("SELECT * FROM `image` WHERE `%s` = '%s'",
            $params[0],
            $params[1]);
        return $this->pdo->query($sql)->fetch();
    }

    public function update($id)
    {
        $data = [
            'file_name' => $this->file_name,
            'slug' => $this->slug,
            'hidden' => $this->hidden,
            'nsfw' => $this->nsfw,
            'id' => $id
        ];

        $sql = "UPDATE image SET file_name=:file_name, slug=:slug, hidden=:hidden, nsfw=:nsfw WHERE id=:id";

        try {
            $this->pdo->prepare($sql)->execute($data);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function insert()
    {
        $data1 = [
            'user_id' => $this->user_id,
            'file_name' => $this->file_name,
            'slug' => $this->slug,
        ];

        $sql = "INSERT INTO image (user_id, file_name, slug) 
                VALUES (:user_id, :file_name, :slug)";

        try {
            $this->pdo->prepare($sql)->execute($data1);
        }catch (\PDOException $e){
            return false;
        }

        $image_id = $this->pdo->lastInsertId();

        $data2 = [
            'image_id' => $image_id,
            'gallery_id' => $this->gallery_id,
        ];

        $sql = "INSERT INTO image_gallery (image_id, gallery_id) 
                VALUES (:image_id, :gallery_id)";

        try {
            $this->pdo->prepare($sql)->execute($data2);
        }catch (\PDOException $e){
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `image` WHERE `id` = $id";
        $this->pdo->query($sql)->execute();
    }
}