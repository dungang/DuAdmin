<?php
namespace app\frontend\controllers;

use Yii;
use app\frontend\forms\LoginForm;
use app\mmadmin\core\BaseController;

class LoginController extends BaseController
{
	public function init(){
		parent::init();
		$this->layout='login';
	}
	
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
            return $this->goHomeOnSuccess();
        } else {
            $model->password = '';
            return $this->render('index', [
                'model' => $model
            ]);
        }
    }
}
