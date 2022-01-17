<?php

namespace app\controllers;

use app\models\GalleryModel;
use app\models\Helper;
use app\models\ImageModel;
use app\models\ModeratorLogModel;
use app\models\Session;
use app\models\UserModel;

class GalleryController extends Controller
{
    private GalleryModel $galleryM;
    private ImageModel $imageM;
    private UserModel $userM;
    private ModeratorLogModel $moderatorLogM;

    public function __construct()
    {
        $this->galleryM = new GalleryModel();
        $this->imageM = new ImageModel();
        $this->userM = new UserModel();
        $this->moderatorLogM = new ModeratorLogModel();

    }

    public function show($slug)
    {
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
        $gallery = $this->galleryM->getGallery(['slug', $slug]);

        $this->renderView('gallery/edit', ['gallery' => $gallery]);
    }

    public function update($slug)
    {
        $gallery = $this->galleryM->getGallery(['slug', $slug]);

        $this->galleryM->name = empty(trim($_POST['name'])) ? $gallery->name : trim($_POST['name']);
        $this->galleryM->description = empty(trim($_POST['description'])) ? $gallery->description : trim($_POST['description']);
        $this->galleryM->hidden = $_POST['hidden'] ? '1' : '0';
        $this->galleryM->nsfw = $_POST['nsfw'] ? '1' : '0';

        $this->galleryM->update($gallery->id);

        if (Session::get('user')->id !== $gallery->user_id && Session::get('user')->role == 'moderator')
        {

            if ($gallery->hidden !== $this->galleryM->hidden) {
                $hidden = "hidden as ".$this->galleryM->hidden;
            }
            if ($gallery->nsfw !== $this->galleryM->nsfw){
                $nsfw = "nsfw as ".$this->galleryM->nsfw;
            }
            $this->moderatorLogM->msg = "Moderator ". Session::get('user')->username ." set gallery ". $gallery->name ." ".$hidden." ".$nsfw ;
            $this->moderatorLogM->logging();
        }

        $this->redirect('imgur/galleries');
    }

    public function create()
    {
        if (Session::get('user')){
            return $this->renderView('gallery/create');
        }else{
            return $this->redirect('');
        }
    }

    public function store()
    {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->galleryM->name = trim($_POST["name"]);
            $this->galleryM->description = trim($_POST["description"]);
            $this->galleryM->user_id = Session::get('user')->id;
            $this->galleryM->slug = Helper::slugify(trim($_POST["name"]).'-'.time());

            $this->galleryM->insert();
            $this->redirect('imgur/profiles/'.Session::get('username'));
        }
    }


}