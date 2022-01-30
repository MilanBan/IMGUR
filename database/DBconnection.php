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
        self::connect();
      }

      return self::$instance;
  }

  private function __construct(){}

  private function __wakeup(){}

  private function __clone(){}

  private static function connect()
  {
      self::$connection = new PDO($_ENV["DB_DSN"], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
      self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  }

  public static function getConnection(){
      return self::$connection;
  }
}