<?php
namespace app\backend\controllers;

use app\mmadmin\core\BackendController;
use app\mmadmin\models\Setting;

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
                'class' => 'app\mmadmin\core\CoreErrorAction'
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

