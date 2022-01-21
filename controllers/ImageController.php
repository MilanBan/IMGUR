<?php

namespace app\controllers;

use app\models\CommentModel;
use app\models\GalleryModel;
use app\models\Helper;
use app\models\ImageModel;
use app\models\ModeratorLogModel;
use app\models\Redis;
use app\models\Session;
use app\models\UserModel;

class ImageController extends Controller
{
    private ImageModel $imageM;
    private UserModel $userM;
    private GalleryModel $galleryM;
    private ModeratorLogModel $moderatorLogM;
    private CommentModel $commentM;

    public function __construct()
    {
        $this->imageM = new ImageModel();
        $this->userM = new UserModel();
        $this->galleryM = new GalleryModel();
        $this->moderatorLogM = new ModeratorLogModel();
        $this->commentM = new CommentModel();

    }

    public function show($slug)
    {
        $image = $this->imageM->getImage(['slug',$slug]);
        $user = $this->userM->getUser(['id', $image->user_id]);
        $gallery = $this->galleryM->getGalleryByImage($image->id);
        $comments = $this->commentM->getAll(['image', $image->id]);

        $this->renderView('image/show', ['image' => $image, 'user' => $user, 'gallery' => $gallery, 'comments'=> $comments]);
    }

    public function edit($slug)
    {
        $image = $this->imageM->getImage(['slug', $slug]);

        $this->renderView('image/edit', ['image' => $image]);
    }

    public function update($slug)
    {
        $image = $this->imageM->getImage(['slug', $slug]);

        $this->imageM->file_name = empty(trim($_POST['file_name'])) ? $image->file_name : trim($_POST['file_name']);
        $this->imageM->slug = (empty(trim($_POST['slug'])) || trim($_POST['slug']) == $image->slug) ? $image->slug : Helper::slugify(trim($_POST['slug'].'-'.$image->id));
        $this->imageM->hidden = $_POST['hidden'] ? '1' : '0';
        $this->imageM->nsfw = $_POST['nsfw'] ? '1' : '0';

        $this->imageM->update($image->id);

        if (Session::get('user')->id !== $image->user_id && Session::get('user')->role == 'moderator')
        {
            if ($image->hidden !== $this->imageM->hidden) {
                $hidden = "hidden as ".$this->imageM->hidden;
            }
            if ($image->nsfw !== $this->imageM->nsfw){
                $nsfw = "nsfw as ".$this->imageM->nsfw;
            }
            $this->moderatorLogM->msg = "Moderator ". Session::get('user')->username ." set image ". $image->file_name ." ".$hidden." ".$nsfw ;
            $this->moderatorLogM->logging();
        }

        $gallery_slug = Session::get('gallery_slug');
        $this->galleryM->session->remove('gallery_slug');

        Session::setFlash('msg', 'Image with id '.$image->id.' hes been updated');

        Redis::remove("*:images:*");

        $this->redirect('imgur/galleries/'.$gallery_slug);
    }

    public function create($slug)
    {
        $data = $this->galleryM->getGallery(['slug', $slug]);
        $gallery = [
            'id' => $data->id,
            'slug' => $data->slug
        ];

        $this->renderView('image/create', ['gallery' => $gallery]);

    }

    public function store($slug)
    {
        if (isset($_POST['file_name']) && isset($_POST['slug'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->imageM->file_name = trim($_POST["file_name"]);
            $this->imageM->slug = Helper::slugify(trim($_POST["slug"]).'-'.time());
            $this->imageM->gallery_id = $_POST['gallery_id'];
            $this->imageM->user_id = Session::get('user')->id;

            $this->imageM->insert();
            $gallery_id = $this->imageM->gallery_id;
            Redis::remove('*:images:*');
            if ($this->imageM->gallery_id){
                Redis::remove("*:galleries:$gallery_id:*");
                Redis::remove("gallery:$gallery_id:show:images:*");
            }

            $this->redirect('imgur/galleries/');
        }
    }

    public function delete($id)
    {
        $image = $this->imageM->getImage(['id', $id]);
        $gallery_slug = $_POST['gallery_slug'];

        if (!$image){
            return ['Image not exist'];
        }

        $this->imageM->delete($id);

        Session::setFlash('msg', 'Image with id '.$id.' hes been deleted');

        Redis::remove('*:images:*');

        $this->redirect('imgur/galleries/'.$gallery_slug);
    }
}