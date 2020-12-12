<?php
namespace Frontend\Controllers;

use Yii;
use Frontend\Forms\LoginForm;
use DuAdmin\Core\GuestController;

class LoginController extends GuestController
{
    
    public $layout = 'login';
	
    /**
     * Login action.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if($referrer = \Yii::$app->request->referrer) {
                return $this->redirect($referrer);
            }
            return $this->goHomeOnSuccess();
        } else {
            $model->password = '';
            return $this->render('index', [
                'model' => $model
            ]);
        }
    }
}

