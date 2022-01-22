<?php

namespace app\models;

use Predis\Client;

class Redis
{

    private static $instance = false;
    public static $cache;

    private static function getInstance()
    {
        if(!self::$instance){
            self::$cache = new Client();
            self::$instance = true;
        }
    }

    public static function exists($key)
    {
        self::getInstance();

        return self::$cache->exists($key);
    }

    public static function caching($key, $value)
    {
        self::getInstance();

        self::$cache->set($key, json_encode($value));
        self::$cache->expire($key, (5*60));
    }

    public static function cached($key)
    {
        return json_decode(self::$cache->get($key));
    }

    public static function reCaching($key, $value)
    {
        self::$cache->del($key);
        self::$cache->set($key, json_encode($value));
        self::$cache->expire($key, (5*60));
    }

    public static function remove($pattern)
    {
        self::getInstance();
        $keys = self::$cache->keys($pattern);
        if (count($keys)){
            self::$cache->del($keys);
        }
    }
}