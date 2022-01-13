<?php

namespace app\models;

class ImageModel extends Model
{
    public function getAll($start, $prePage)
    {
        var_dump('uslo u getAll');
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
        var_dump('uslo u getAllByGallery');

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
        }if ($gallery_id){                                                              // Gallery - show
        $sql= sprintf("SELECT count(*) as 'total' FROM `image_gallery` WHERE gallery_id = %s",
               $gallery_id
               );
        }else{                                                                           // Site - index
            $sql = "SELECT count(*) as 'total' FROM image WHERE `hidden` = 0 AND `nsfw` = 0";
        }

        return $this->pdo->query($sql)->fetch();
    }

    public function getImage($slug)
    {
        var_dump('uslo u getImage');
        $sql = sprintf("SELECT * FROM `image` WHERE `slug` = '%s'",
            $slug);
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
        }catch (\PDOException $e){
            return false;
        }
    }

}

// za total slika u gallery show-u
//                $sql= sprintf("select count (*) as 'total' from `image_gallery` ig
//            inner join `image` i on ig.`image_id` = i.`id`
//            inner join `gallery` g on ig.`gallery_id` = g.`id`
//            where g.id =:id",
//               $gallery_id
//               );
// kraj