<?php

namespace Frontend\Controllers;

use DuAdmin\Core\BaseController;
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
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
