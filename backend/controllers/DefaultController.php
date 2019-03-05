<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;

class DefaultController extends BackendController
{
    public function actionIndex(){
        return $this->render('index');
    }
}

