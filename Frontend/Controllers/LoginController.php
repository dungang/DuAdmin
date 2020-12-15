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
            return $this->goBackOnSuccess();
        } else {
            //只需要添加这句话就可以了
            Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
            $model->password = '';
            return $this->render('index', [
                'model' => $model
            ]);
        }
    }
}

