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
        var_dump('gallery show ctrl');
        $gallery = $this->galleryM->getGallery(['slug', $slug]);
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
        $this->renderView('gallery/show', ['gallery' => $gallery, 'images' => $images, 'user' => $user, 'pagination' => $pagination]);
    }

    public function edit($slug)
    {
        var_dump('gallery edit ctrl');

        $gallery = $this->galleryM->getGallery(['slug', $slug]);

        $this->renderView('gallery/edit', ['gallery' => $gallery]);
    }

    public function update($slug)
    {
        $gallery = $this->galleryM->getGallery(['slug', $slug]);

        $this->galleryM->name = !empty(trim($_POST['name'])) ? trim($_POST['name']) : $gallery->name;
        $this->galleryM->description = !empty(trim($_POST['description'])) ? trim($_POST['description']) : $gallery->description;
        $this->galleryM->hidden = (isset($_POST['hidden']) ? '1' : '0');
        $this->galleryM->nsfw = (isset($_POST['nsfw']) ? '1' : '0');

        $this->galleryM->update($gallery->id);

        $this->redirect('/imgur/galleries');
    }

}