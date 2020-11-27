<?php
namespace app\frontend\controllers;

use app\mmadmin\helpers\MAHelper;
use app\mmadmin\hooks\FindSlugHook;
use app\mmadmin\core\BaseController;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    public function init()
    {
        parent::init();

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => MAHelper::getSetting('site.keywords')
        ], 'keywords');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => MAHelper::getSetting('site.description')
        ], 'description');
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
                'class' => '\yii\captcha\CaptchaAction',
                'offset' => '0',
                'maxLength' => 4,
                'minLength' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * 检查是否有数据库级别的配置
     *
     *
     * @return string
     */
    public function actionIndex()
    {
        if ($url = MAHelper::getSetting("site.index-page")) {
            return $this->redirect($url);
        } else {
            return $this->render("index");
        }
    }

    /**
     * 显示页面
     *
     * @param string $slug
     * @throws \yii\web\NotFoundHttpException
     * @return mixed|NULL|string
     */
    public function actionPage($slug = 'index')
    {
        // try to display action from controller
 
        try {
            return $this->run('/'. $slug);
        } catch (\yii\base\InvalidRouteException $ex) {
            \Yii::debug($ex->getMessage());die;
        }

        // try to display action from application
        try {
            return \Yii::$app->runAction($slug . '/');
        } catch (\yii\base\InvalidRouteException $ex) {}

        // try to display static page from hook handler
        $hook = FindSlugHook::emit($this, [
            'slug' => $slug
        ]);
        if ($hook && $hook->payload) {
            return $hook->payload;
        }
        // if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
