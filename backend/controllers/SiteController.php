<?php
namespace Backend\Controllers;

use DuAdmin\Core\BaseController;

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
                'class' => 'DuAdmin\Uploader\LocalUploadAction'
            ],
            'upload-token' => [
                'class' => 'DuAdmin\Uploader\TokenAction'
            ],
            'upload-delete' => [
                'class' => 'DuAdmin\Uploader\DeleteAction'
            ]
        ];
    }
}
