<?php

namespace app\models;

use app\database\DBconnection;

class Model
{
    protected $db;
    public $pdo;
    public $session = null;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
        $this->pdo = $this->db->getConnection();
        $this->session = new Session();
    }

    public function deleteSession()
    {
        $this->session->destroy();
    }

    public function updateSession($key, $value)
    {
        $this->session->update($key, $value);
    }
}