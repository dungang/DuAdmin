<?php
namespace app\api\controllers;

use app\kit\core\BaseController;

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
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }
}