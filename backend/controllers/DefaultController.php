<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\kit\models\Setting;

class DefaultController extends BackendController
{

    public function init()
    {
        parent::init();
        $this->guestActions = [
            'error'
        ];
        $this->userActions = [
            'index'
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    public function actionIndex()
    {
        if ($index = Setting::getSettings('backend.index')) {
            return $this->redirect([
                '/'.ltrim($index)
            ]);
        }
        return $this->render('index');
    }
}

