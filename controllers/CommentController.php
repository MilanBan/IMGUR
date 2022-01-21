<?php

namespace app\controllers;

use app\models\CommentModel;
use app\models\Redis;
use app\models\Session;

class CommentController extends Controller
{
    private CommentModel $commentM;

    public function __construct()
    {
        $this->commentM = new CommentModel();
    }

    public function store()
    {
        if (isset($_POST['comment'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->commentM->user_id = Session::get('user')->id;
            $this->commentM->comment = trim($_POST['comment']);
            $this->commentM->gallery_id = $_POST['gallery_id'] ?? null;
            $this->commentM->image_id = $_POST['image_id'] ?? null;

            $this->commentM->insert();

            $this->refresh();
        }
    }
}