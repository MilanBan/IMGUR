<?php

namespace app\controllers;

use app\models\GalleryModel;
use app\models\Helper;
use app\models\Session;
use app\models\UserModel;

class UserController extends Controller
{

    private UserModel $userM;
    private GalleryModel $galleryM;

    public function __construct()
    {
        $this->userM = new UserModel();
        $this->galleryM = new GalleryModel();
    }

    public function profile()
    {
        $user = $this->userM->getUser(['id', Session::get('user')->id]);

        $this->renderView('home', ['user' => $user]);
    }

    public function show($username)
    {
        $user = $this->userM->getUser(['username', Helper::decode($username)]);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $prePage = isset($_GET['pre-page']) && $_GET['pre-page'] <= 50 ? (int)$_GET['pre-page'] : 20;
        $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
        $total = $this->galleryM->getTotal($user->id)->total;

        $pages = ceil($total / $prePage);

        $galleries = $this->galleryM->getGalleriesForUser($user->id, $start, $prePage);

        $pagination =[
            'page' => $page,
            'prePage' => $prePage,
            'start' => $start,
            'total' => $total,
            'pages' => $pages,
            'url' => '/imgur/profiles/'.Helper::encode($user->username)
        ];

        $cover = [];

        foreach ($galleries as $gallery){
            $cover[$gallery->id] = $this->galleryM->getCover($gallery->id);
        }

        $this->renderView('profile/show', array('user' => $user, 'galleries' => $galleries, 'cover' => $cover, 'pagination' => $pagination));
    }

    public function edit($username)
    {
        $user = $this->userM->getUser(['username', Helper::decode($username)]);

        $this->renderView('profile/edit', ['user' => $user]);
    }

    public function update($username)
    {
        $user = $this->userM->getUser(['username', Helper::decode($username)]);

        $this->userM->username = trim($_POST['username']) ?? $user->username;
        $this->userM->email = trim($_POST['email']) ?? $user->email;
        $this->userM->active = $_POST['active'] ? '1' : '0';
        $this->userM->nsfw = $_POST['nsfw'] ? '1' : '0';

        $this->userM->update($user->id);

        $this->redirect('imgur/profiles/'.Helper::encode($user->username));
    }
}