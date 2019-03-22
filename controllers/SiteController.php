<?php
namespace app\controllers;

use app\kit\core\FrontendController;
use app\kit\components\Crontab;

/**
 * Site controller
 */
class SiteController extends FrontendController
{

    public function init()
    {
        parent::init();
        $this->guestActions = [
            'login',
            'error',
            'about',
            'index'
        ];
        $this->userActions = [
            'logout'
        ];
        $this->verbsActions = [
            'logout' => [
                'post'
            ]
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
        return \function_exists('stream_socket_client');
        //return date('Y-m-d H:i:s',Crontab::parse('12 * * * 1-5')) . '=' .date('Y-m-d H:i:s');
        //return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
