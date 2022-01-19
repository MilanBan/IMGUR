<?php

namespace app\models;

class CommentModel extends Model
{

    public function getAll(array $params)
    {
        if (Redis::exists("gallery:comments"))
        {
            var_dump('redis comments');
            return Redis::cached("gallery:comments");

        }else{
            $sql = sprintf("SELECT comment.`comment`, user.`username`, comment.`id` FROM `comment` INNER JOIN `user` ON comment.`user_id` = user.`id` WHERE comment.`%s` = '%s' ORDER BY comment.`id` DESC",
                $params[0],
                $params[1]
            );

            $results = $this->pdo->query($sql)->fetchAll();

            Redis::caching("gallery:comments", $results);
var_dump('db comments');
            return $results;
        }
    }

    public function insert()
    {
        $data = [
            'user_id' => $this->user_id,
            'comment' => $this->comment,
            'gallery_id' => $this->gallery_id,
            'image_id' => $this->image_id
        ];
//var_dump($data); exit();
        $sql = "INSERT INTO comment (user_id, comment, gallery_id, image_id) 
                VALUES (:user_id, :comment, :gallery_id, :image_id)";

        try {
            $this->pdo->prepare($sql)->execute($data);
        }catch (\PDOException $e){
            return false;
        }
    }
}