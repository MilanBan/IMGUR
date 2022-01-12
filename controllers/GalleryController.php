<?php

namespace app\controllers;

use app\models\GalleryModel;
use app\models\ImageModel;
use app\models\UserModel;

class GalleryController extends Controller
{
    private GalleryModel $galleryM;
    private ImageModel $imageM;
    private UserModel $userM;

    public function __construct()
    {
        $this->galleryM = new GalleryModel();
        $this->imageM = new ImageModel();
        $this->userM = new UserModel();
    }

    public function show($slug)
    {
        $gallery = $this->galleryM->find($slug);
        $user = $this->userM->getUser(['id', $gallery->user_id]);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $prePage = isset($_GET['pre-page']) && $_GET['pre-page'] <= 50 ? (int)$_GET['pre-page'] : 20;
        $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
        $total = $this->imageM->getTotal($gallery->id)->total;

        $pages = ceil($total / $prePage);

        $pagination =[
            'page' => $page,
            'prePage' => $prePage,
            'start' => $start,
            'total' => $total,
            'pages' => $pages,
            'url' => '/imgur/galleries/'.$gallery->slug
        ];

        $images = $this->imageM->getAllByGallery($gallery->id, $start, $prePage);
        $this->renderView('gallery/show', ['gallery' => $gallery, 'images' => $images, 'user' => $user]);
    }
}