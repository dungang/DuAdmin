<?php
namespace app\controllers;

use app\kit\core\FrontendController;
use yii\base\InvalidArgumentException;
use app\kit\models\Page;
use app\kit\helpers\KitHelper;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    
    public function init()
    {
        parent::init();
        $this->layout = '@app/addons/travel/views/layouts/front-end.php';
        $this->guestActions = [
            'error',
            'index',
            'captcha',
            'wechat'
        ];
        
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => KitHelper::getSetting('site.keywords')
        ],'keywords');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => KitHelper::getSetting('site.description')
        ],'description');
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
            ],
            'wechat'=>[
                'class'=>'app\kit\components\WechatServerAction'
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
        if (KitHelper::getSetting("site.index-page")) {
            return $this->goHome();
        } else {
            throw new InvalidArgumentException('默认首页配置`site.index-page`不能为空');
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
        //try to display action from controller
        try {
            return $this->runAction($slug);
        } catch (\yii\base\InvalidRouteException $ex) {}

        //try to display action from application
        try {
            return \Yii::$app->runAction($slug . '/');
        } catch (\yii\base\InvalidRouteException $ex) {}

        //try to display static page from datebase
        if ($page = Page::findOne([
            'slug' => $slug
        ])) {
            return $this->render('page', [
                'model' => $page
            ]);
        }
        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }
}
