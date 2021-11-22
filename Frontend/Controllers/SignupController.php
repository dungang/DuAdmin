<?php

namespace Frontend\Controllers;

use DuAdmin\Core\BaseController;
use DuAdmin\Helpers\AppHelper;
use Frontend\Forms\SignupForm;
use Yii;

class SignupController extends BaseController
{
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (!AppHelper::getSetting('site.open-signup')) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            $encodeEmail = AppHelper::hideStar($model->email);
            return $this->render('success', ['encodeEmail' => $encodeEmail]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
