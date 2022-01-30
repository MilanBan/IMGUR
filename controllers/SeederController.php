<?php

namespace app\controllers;

use app\models\SeederModel;


class SeederController extends Controller
{
    private SeederModel $seeder;

    public function __construct()
    {
        $this->seeder = new SeederModel();
    }

    public function seed()
    {
        $this->seeder->seedFreeSubsForAllUsers();
    }
}