<?php

namespace app\controllers;

use app\models\ImageModel;

class SiteController extends Controller
{
    private ImageModel $imageM;

    public function __construct()
    {
        $this->imageM = new ImageModel();
    }

    public function images()
    {

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $prePage = isset($_GET['pre-page']) && $_GET['pre-page'] <= 50 ? (int)$_GET['pre-page'] : 20;
        $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
        $total = $this->imageM->getTotal()->total;

        $pages = ceil($total / $prePage);

        $pagination =[
            'page' => $page,
            'prePage' => $prePage,
            'start' => $start,
            'total' => $total,
            'pages' => $pages,
            'url' => '/home'
        ];

        $images = $this->imageM->getAll($start, $prePage);

        $this->renderView('home/index', ['images' => $images, 'pagination' => $pagination]);
    }

    public function galleries()
    {
        $this->renderView('home/galleries');
    }

    public function profiles()
    {
        $this->renderView('home/profiles');
    }
}