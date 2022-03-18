<?php

namespace app\models;

class Advertising extends Model
{
    public static $banners = null;

    public function countClicks($name, $banner_id)
    {
        $sector_key = 'sector:clicks:'.$name;
        if (Redis::exists($sector_key)){
            Redis::increment($sector_key);
        }else{
            Redis::permanentCaching($sector_key, 1);
        }

        $banner_key = 'banner:clicks:'.$banner_id;
        if (Redis::exists($banner_id)){
            Redis::increment($banner_id);
        }elseif($banner_id !==0){
            Redis::permanentCaching($banner_id, 1);
        }

    }

    public function getAllInactiveBanner()
    {
        return $this->pdo->query("select * from banner where active = 0")->fetchAll();
    }

    public function find($id)
    {
        return $this->pdo->query("select * from banner where id = $id")->fetch();
    }

    public function switchActive($id, $active)
    {
        if ($active == 1){
            return $this->pdo->prepare("update banner set active = 0 where id = $id")->execute();
        }
        else {
            return $this->pdo->prepare("update banner set active = 1 where id = $id")->execute();
        }
    }

    public function countViews($banner_id)
    {
        $key = 'banner:views:'.$banner_id;

        if (Redis::exists($key)){
            Redis::increment($key);
        }else{
            Redis::permanentCaching($key, 1);
        }
    }

    public function pickNext()
    {
        $banners = $this->getAllInactiveBanner();
        $next_id = rand(1,count($banners));
        $next = $this->find($next_id);
//        $this->switchActive($next->id, $next->active);
        $this->countViews($next->id);

        return $next;
    }

    public function nextRendering()
    {
        self::$banners = [
            'h' => $this->pickNext(),
            'ls' => $this->pickNext(),
            'rs' => $this->pickNext(),
            'f' => $this->pickNext(),
        ];
    }

    public static function getInstance(): ?Advertising
    {
        if (self::$banners == null){
            self::$banners = new Advertising();
        }
        return self::$banners;
    }

}