<?php

namespace app\models;

use Carbon\Carbon;

class ImageModel extends Model
{
    public function getAll($start, $prePage, $page)
    {
        if (in_array(Session::get('user')->role, ['admin', 'moderator']))
        {
            if (Redis::exists("a:site:images:$page"))
            {
                var_dump('redis getAll images');

                return Redis::cached("a:site:images:$page");

            } else {
                $sql = sprintf("SELECT `slug`, `file_name` FROM `image` LIMIT %s, %s",
                    $start,
                    $prePage
                );

                $results = $this->pdo->query($sql)->fetchAll();

                Redis::caching("a:site:images:$page", $results);
                var_dump('db getAll images');

                return $results;
            }
        } else {
            if (Redis::exists("u:site:images:$page"))
            {
                var_dump('is redisa');
                return Redis::cached("u:site:images:$page");

            } else {
                $sql = sprintf("SELECT `slug`, `file_name` FROM `image` WHERE `hidden` = 0 AND `nsfw` = 0 LIMIT %s, %s",
                    $start,
                    $prePage
                );

                $results = $this->pdo->query($sql)->fetchAll();

                Redis::caching("u:site:images:$page", $results);
                var_dump('is konekcije');
                return $results;
            }
        }
    }

    public function getAllByGallery($gallery_id, $start, $prePage, $page)
    {
        if (Redis::exists("gallery:$gallery_id:show:images:$page"))
        {
            var_dump('redis getAllByGallery images');
            return Redis::cached("gallery:$gallery_id:show:images:$page");

        }else {
            $sql = sprintf("SELECT i.`slug`, i.`file_name` FROM `image` i INNER JOIN `image_gallery` ig ON i.`id` = ig.`image_id` WHERE ig.`gallery_id` = %s ORDER BY i.`id` DESC LIMIT %s, %s",
                $gallery_id,
                $start,
                $prePage
            );

            $results = $this->pdo->query($sql)->fetchAll();
            Redis::caching("gallery:$gallery_id:show:images:$page", $results);
            var_dump('db getAllByGallery images');
            return $results;
        }
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
        $limit = $this->checkLimit();

        $plan_limit = [
            'free' => 5,
            '1 month' => 20,
            '6 months' => 30,
            '12 months' => 50
        ];

        if ($limit >= $plan_limit[Session::get('subs')]){
            Session::setFlash('msg', 'You used the upload limit. Upgrade the subscription plan to increase the limit.');
            return false;
        }

        $data = [
            'user_id' => $this->user_id,
            'file_name' => $this->file_name,
            'slug' => $this->slug,
            'created_at' => Carbon::now()->format("Y-m-d")
        ];

        $sql = "INSERT INTO image (user_id, file_name, slug, created_at) 
                VALUES (:user_id, :file_name, :slug, :created_at)";

        try {
            $this->pdo->prepare($sql)->execute($data);
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
            return $this->pdo->prepare($sql)->execute($data2);
        }catch (\PDOException $e){
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `image` WHERE `id` = $id";
        $this->pdo->query($sql)->execute();
    }

    public function checkLimit()
    {
        $months = Session::get('sub-data')['months'];
        $expire = Session::get('sub-data')['expire'];
        $id = Session::get('user')->id;

        if (Session::get('subs') == 'free')
        {
            $start_of_month = (new Carbon('first day of this month'))->format("Y-m-d");
            $end_of_month = Carbon::now()->format('Y-m-d');

        }else{

            $end_of_month = Carbon::createFromFormat("Y-m-d",$expire)->subMonths($months-1)->format('Y-m-d');
            $start_of_month = Carbon::createFromFormat("Y-m-d",$expire)->subMonths($months)->format('Y-m-d');
            $now = Carbon::now()->format('Y-m-d');

            while ($end_of_month < $now){
                $end_of_month = Carbon::createFromFormat("Y-m-d",$end_of_month)->addMonth()->format('Y-m-d');
                $start_of_month = Carbon::createFromFormat("Y-m-d",$start_of_month)->addMonth()->format('Y-m-d');
            }

        }
        $sql = "SELECT count(*) FROM image WHERE user_id = $id AND created_at BETWEEN '$start_of_month' AND '$end_of_month'";

        $count = $this->pdo->query($sql)->fetchColumn();
        return $count;
    }
}