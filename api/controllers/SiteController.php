<?php

namespace app\api\controllers;

use DuAdmin\Core\ApiController;

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
