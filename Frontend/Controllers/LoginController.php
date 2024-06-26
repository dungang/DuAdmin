<?php

namespace Frontend\Controllers;

use DuAdmin\Core\BaseController;
use DuAdmin\Helpers\AppHelper;
use Frontend\Forms\LoginForm;
use Yii;

class LoginController extends BaseController
{


  /**
   * Login action.
   *
   * @return string
   */
  public function actionIndex()
  {

    if (!Yii::$app->user->isGuest || !AppHelper::getSetting('site.open-login')) {
      return $this->goHome();
    }
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->redirectSuccess(\Yii::$app->user->getReturnUrl(), "登录成功");
    } else {
      // 只需要添加这句话就可以了
      Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
      $model->password = '';
      return $this->render('index', [
        'model' => $model
      ]);
    }
  }
}
