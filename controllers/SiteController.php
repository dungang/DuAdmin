<?php

namespace app\controllers;

use app\kit\core\FrontendController;
use yii\base\InvalidArgumentException;
use app\kit\helpers\KitHelper;
use app\kit\events\SlugEvent;

/**
 * Site controller
 */
class SiteController extends FrontendController {

    public function init() {
        parent::init();
        $this->guestActions = [
            'error',
            'index',
            'captcha',
            'wechat'
        ];

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => KitHelper::getSetting('site.keywords')
                ], 'keywords');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => KitHelper::getSetting('site.description')
                ], 'description');
    }

    /**
     *
     * {@inheritdoc}
     */
    public function actions() {
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
     * @return string
     */
    public function actionIndex() {
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
    public function actionPage($slug = 'index') {
        //try to display action from controller
        try {
            return $this->runAction($slug);
        } catch (\yii\base\InvalidRouteException $ex) {
    
        }

        //try to display action from application
        try {
            return \Yii::$app->runAction($slug . '/');
        } catch (\yii\base\InvalidRouteException $ex) {
            
        }

        //try to display static page from datebase
        // if ($page = Page::findOne([
        //             'slug' => $slug
        //         ])) {
        //     return $this->render('page', [
        //                 'model' => $page
        //     ]);
        // }
        $event = new SlugEvent([
            'slug'=>$slug,
        ]);
        $this->trigger('findSlugContent',$event);
        if($event->content) {
            return $event->content;
        }
        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

}
