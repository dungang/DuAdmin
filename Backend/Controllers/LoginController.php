<?php
namespace Backend\Controllers;

use Yii;
use Backend\Forms\LoginForm;
use DuAdmin\Core\BaseController;

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
            return $this->goBackOnSuccess();
        } else {
            $model->password = '';
            //只需要添加这句话就可以了
            Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
            return $this->render('index', [
                'model' => $model
            ]);
        }
    }
}

