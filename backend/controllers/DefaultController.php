<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use DuAdmin\Models\Setting;

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
                'class' => 'DuAdmin\Core\CoreErrorAction'
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

