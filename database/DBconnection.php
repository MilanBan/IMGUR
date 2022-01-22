<?php

namespace app\database;

use PDO;

class DBconnection {

  private static $instance = null;
  private static $connection;

  public static function getInstance()
  {
      if(is_null(self::$instance)){
        self::$instance = new DBconnection();
      }

      return self::$instance;
  }

  public function __construct(){}

  public function __wakeup(){}

  public function __clone(){}

    public static function connect()
  {
      self::$connection = new PDO($_ENV["DB_DSN"], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
      self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  }

  public static function getConnection(){
      return self::$connection;
  }
}