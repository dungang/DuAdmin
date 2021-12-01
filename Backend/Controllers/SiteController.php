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
                'class' => 'DuAdmin\Core\CustomErrorAction',
                'layout' => 'content'
            ],
            'captcha' => [
                'class' => '\yii\captcha\CaptchaAction',
                'offset' => '0',
                'maxLength' => 4,
                'minLength' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'dict' => [
                'class' => '\DuAdmin\Dict\DictAction',
            ],
            'upload' => [
                'class' => '\DuAdmin\Uploader\LocalUploadAction'
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
