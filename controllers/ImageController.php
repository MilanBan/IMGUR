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

    public function edit($slug)
    {
        $image = $this->imageM->getImage($slug);

        $this->renderView('image/edit', ['image' => $image]);
    }

    public function update($slug)
    {
        $image = $this->imageM->getImage($slug);

        $this->imageM->file_name = trim($_POST['file_name']) ?? $image->file_name;
        $this->imageM->slug = trim($_POST['slug']) ?? $image->slug;
        $this->imageM->hidden = $_POST['hidden'] ? '1' : '0';
        $this->imageM->nsfw = $_POST['nsfw'] ? '1' : '0';

        $this->imageM->update($image->id);

        $this->redirect('/imgur/galleries/images/'.$this->imageM->slug);
    }
}