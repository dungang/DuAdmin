<?php
namespace app\controllers;

use app\kit\core\FrontendController;

/**
 * Site controller
 */
class SiteController extends FrontendController
{

    public function init()
    {
        parent::init();
        $this->guestActions = [
            'error',
            'index'
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->goHome();
    }
}
