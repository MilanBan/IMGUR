<?php

namespace app\models;

class CommentModel extends Model
{

    public function getAll(array $params)
    {
        if (Redis::exists("$params[0]:$params[1]:comments"))
        {
            var_dump("redis comments params:$params[0]:$params[1]");
            return Redis::cached("$params[0]:$params[1]:comments");

        }else{
            $sql = sprintf("SELECT comment.`comment`, user.`username`, comment.`id` FROM `comment` INNER JOIN `user` ON comment.`user_id` = user.`id` WHERE comment.`%s_id` = '%s' ORDER BY comment.`id` DESC",
                $params[0],
                $params[1]
            );

            $results = $this->pdo->query($sql)->fetchAll();

            Redis::caching("$params[0]:$params[1]:comments", $results);
            var_dump('db comments params '.$params[0].':'.$params[1]);
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

        $sql = "INSERT INTO comment (user_id, comment, gallery_id, image_id) 
                VALUES (:user_id, :comment, :gallery_id, :image_id)";

        $params = $data['image_id'] ? 'image' : 'gallery';
        $id = $data['image_id'] ? $data['image_id'] : $data['gallery_id'];

        Redis::remove("$params:$id:comments");
        try {
            $this->pdo->prepare($sql)->execute($data);
        }catch (\PDOException $e){
            return false;
        }
    }
}