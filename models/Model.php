<?php

namespace app\models;

use app\database\DBconnection;

class Model
{
    protected $db;
    protected $pdo;
    public $session = null;

    public function __construct()
    {
        DBConnection::connect("mysql:host=127.0.0.1;dbname=quant-zadatak","root", "root");
        $this->db = DBConnection::getInstance();
        $this->pdo = $this->db->getConnection();

        $this->session = new Session();
    }

    public function deleteSession()
    {
        $this->session->destroy();
    }
}