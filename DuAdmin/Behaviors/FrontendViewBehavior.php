<?php

namespace DuAdmin\Behaviors;

use voku\helper\HtmlMin;
use yii\base\Behavior;
use yii\base\ViewEvent;
use yii\web\View;

class FrontendViewBehavior extends Behavior
{

    /**
     * 最小化前端视图的文档
     * @var HtmlMin
     */
    public static $miniHtml;

    public function init()
    {
        if (empty(static::$miniHtml)) {
            static::$miniHtml = new HtmlMin();
        }
    }

    public function events()
    {

        return [
            View::EVENT_AFTER_RENDER => 'process'
        ];
    }

    /**
     *
     * @param ViewEvent $event
     */
    public function process($event)
    {
        //注册基础的meta
        $this->owner->registerMetaTag([
            'name'    => 'generator',
            'content' => 'DuAdmin'
        ], 'generator');
        $this->owner->registerMetaTag([
            'name'    => 'referrer',
            'content' => 'always'
        ], 'referrer');
        $this->owner->registerMetaTag([
            'name'    => 'renderer',
            'content' => 'webkit'
        ], 'renderer');
        $this->owner->registerMetaTag([
            'name'    => 'force-rendering',
            'content' => 'webkit'
        ], 'force-rendering');
        $this->miniHtml($event);
    }

    public function miniHtml($event)
    {
        if (($out = $event->output) && YII_ENV_PROD) {
            $event->output = static::$miniHtml->minify($out);
        }
    }
}
