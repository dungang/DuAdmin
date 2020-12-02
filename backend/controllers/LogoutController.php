<?php
namespace Backend\Controllers;

use Yii;
use yii\web\Controller;

class LogoutController extends Controller
{
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}

