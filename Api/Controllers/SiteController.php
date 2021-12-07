<?php

namespace Api\Controllers;

use DuAdmin\Core\ApiController;

/**
 * Site controller
 */
class SiteController extends ApiController
{
    public $authExceptActions = ['error', 'index'];

    /**
     *
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'sms-captcha'        => [
                'class' => '\DuAdmin\Sms\SendSmsCaptchaAction'
            ],
            'mail-captcha'        => [
                'class' => '\DuAdmin\Mail\SendMailCaptchaAction'
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

    public function actionIndex()
    {
        return 1;
    }
}
