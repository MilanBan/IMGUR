<?php

namespace app\controllers;

class Controller
{

    public function renderView($view, $data = [])
    {
        if (!file_exists(__DIR__."/../views/$view.php"))
        {
            return "404 | Page not found";
        }else{
            require_once __DIR__.'/../views/includes/header.php';
            require_once __DIR__."/../views/$view.php";
            require_once __DIR__.'/../views/includes/footer.php';
        }
    }

    public function redirect($url)
    {
        header("Location: http://localhost:8080/$url");
    }

    public function refresh()
    {
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}