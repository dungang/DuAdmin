<?php

namespace app\api\controllers;

use app\mmadmin\core\ApiController;

/**
 * Site controller
 */
class SiteController extends ApiController
{
    public $authExceptActions = ['error'];

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
            'upload' => [
                'class' => 'app\mmadmin\uploader\LocalUploadAction'
            ],
            'token' => [
                'class' => 'app\mmadmin\uploader\TokenAction'
            ]
        ];
    }
}
