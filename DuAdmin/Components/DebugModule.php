<?php

namespace DuAdmin\Components;

use yii\debug\Module;
use yii\base\Application;
use yii\debug\LogTarget;
use yii\web\Response;
use yii\web\View;
use Yii;
use yii\web\ForbiddenHttpException;

class DebugModule extends Module
{


    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        /* @var $app \yii\base\Application */
        $this->logTarget = $app->getLog()->targets['debug'] = new LogTarget($this);

        // delay attaching event handler to the view component after it is fully configured
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $app->getResponse()->on(Response::EVENT_AFTER_PREPARE, [$this, 'setDebugHeaders']);
        });
        $app->on(Application::EVENT_BEFORE_ACTION, function () use ($app) {
            $app->getView()->on(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        });

        $app->getUrlManager()->addRules([
            [
                'class' => $this->urlRuleClass,
                'route' => $this->id,
                'pattern' => $this->id,
                'normalizer' => false,
                'suffix' => false
            ],
            [
                'class' => $this->urlRuleClass,
                'route' => $this->id . '/<controller>/<action>',
                'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>',
                'normalizer' => false,
                'suffix' => false
            ]
        ], false);
    }

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if (!$this->enableDebugLogs) {
            foreach ($this->get('log')->targets as $target) {
                $target->enabled = false;
            }
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->offRegistEvents();

        if ($this->checkAccess($action)) {
            $this->resetGlobalSettings();
            return true;
        }

        if ($action->id === 'toolbar') {
            // Accessing toolbar remotely is normal. Do not throw exception.
            return false;
        }

        throw new ForbiddenHttpException('You are not allowed to access this page.');
    }

    public function offRegisterEvents()
    {
        // do not display debug toolbar when in debug view mode
        Yii::$app->getView()->off(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        Yii::$app->getResponse()->off(Response::EVENT_AFTER_PREPARE, [$this, 'setDebugHeaders']);
    }


    public static function removeDebugRender()
    {
        if (YII_ENV_DEV) {
            if (Yii::$app->modules['debug']) {
                Yii::$app->modules['debug']->offRegisterEvents();
            }
        }
    }
}
