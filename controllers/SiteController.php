<?php
namespace app\controllers;

use app\kit\core\FrontendController;
use yii\base\InvalidArgumentException;
use app\kit\models\Setting;

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
            'index',
            'captcha',
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
        if (Setting::getSettings("site.index-page")) {
            return $this->goHome();
        } else {
            throw new InvalidArgumentException('默认首页配置`site.index-page`不能为空');
        }
    }
}
