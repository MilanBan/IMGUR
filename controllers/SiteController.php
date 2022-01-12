<?php

namespace app\controllers;

use app\models\GalleryModel;
use app\models\ImageModel;
use app\models\Session;
use app\models\UserModel;

class SiteController extends Controller
{
    private ImageModel $imageM;
    private GalleryModel $galleryM;
    private UserModel $userM;

    public function __construct()
    {
        $this->imageM = new ImageModel();
        $this->galleryM = new GalleryModel();
        $this->userM = new UserModel();
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
            'url' => '/imgur'
        ];

        $images = $this->imageM->getAll($start, $prePage);

        $this->renderView('home/index', ['images' => $images, 'pagination' => $pagination]);
    }

    public function galleries()
    {
        if (!Session::get('user')){
            $this->redirect('/imgur');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $prePage = isset($_GET['pre-page']) && $_GET['pre-page'] <= 50 ? (int)$_GET['pre-page'] : 20;
        $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
        $total = $this->galleryM->getTotal()->total;

        $pages = ceil($total / $prePage);

        $pagination =[
            'page' => $page,
            'prePage' => $prePage,
            'start' => $start,
            'total' => $total,
            'pages' => $pages,
            'url' => '/imgur/galleries'
        ];

        $galleries = $this->galleryM->getAll($start, $prePage);

        $cover = [];

        foreach ($galleries as $gallery){
            $cover[$gallery->id] = $this->galleryM->getCover($gallery->id);

        }

        $this->renderView('home/galleries', ['galleries' => $galleries, 'cover' => $cover, 'pagination' => $pagination]);
    }

    public function profiles()
    {
        if (!Session::get('user')){
            $this->redirect('/imgur');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $prePage = isset($_GET['pre-page']) && $_GET['pre-page'] <= 50 ? (int)$_GET['pre-page'] : 20;
        $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
        $total = $this->userM->getTotal()->total;

        $pages = ceil($total / $prePage);

        $pagination =[
            'page' => $page,
            'prePage' => $prePage,
            'start' => $start,
            'total' => $total,
            'pages' => $pages,
            'url' => '/imgur/profiles'
        ];

        $users = $this->userM->getAll($start, $prePage);

        $this->renderView('home/profiles', ['users' => $users, 'pagination' => $pagination]);
    }
}