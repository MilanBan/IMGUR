<?php

namespace app\controllers;

class Controller
{
    public function renderVidew($view, $data = [])
    {
        if (file_exists(__DIR__."/../views/$view.php"))
        {
            require_once __DIR__."/../views/$view.php";
        }else{
            echo "404 | Page not found";
        }
    }
}