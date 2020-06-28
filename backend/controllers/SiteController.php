<?php
namespace app\backend\controllers;

use app\mmadmin\core\BaseController;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     *
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout'=> 'login'
            ],
            'captcha' => [
                'class' => '\yii\captcha\CaptchaAction',
                'offset' => '0',
                'maxLength' => 4,
                'minLength' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'upload' => [
                'class' => 'app\mmadmin\uploader\LocalUploadAction'
            ],
            'upload-token' => [
                'class' => 'app\mmadmin\uploader\TokenAction'
            ],
            'upload-delete' => [
                'class' => 'app\mmadmin\uploader\DeleteAction'
            ]
        ];
    }
}
