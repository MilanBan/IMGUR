<?php

namespace app\controllers;

use app\models\GalleryModel;
use app\models\ImageModel;
use app\models\UserModel;

class ImageController extends Controller
{
    private ImageModel $imageM;
    private UserModel $userM;
    private GalleryModel $galleryM;

    public function __construct()
    {
        $this->imageM = new ImageModel();
        $this->userM = new UserModel();
        $this->galleryM = new GalleryModel();
    }

    public function show($slug)
    {
        var_dump('image show ctrl');

        $image = $this->imageM->getImage($slug);
        $user = $this->userM->getUser(['id', $image->user_id]);
        $gallery = $this->galleryM->getGalleryByImage($image->id);

        $this->renderView('image/show', ['image' => $image, 'user' => $user, 'gallery' => $gallery]);
    }
}