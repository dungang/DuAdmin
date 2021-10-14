<?php

namespace DuAdmin\Behaviors;

use voku\helper\HtmlMin;
use yii\base\Behavior;
use yii\base\ViewEvent;
use yii\web\View;

class MiniHtmlBehavior extends Behavior
{

    /**
     *
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
            View::EVENT_AFTER_RENDER => 'miniHtml'
        ];
    }

    /**
     *
     * @param ViewEvent $event
     */
    public function miniHtml($event)
    {
        if (($out = $event->output) && YII_ENV_PROD) {
            $event->output = static::$miniHtml->minify($out);
        }
    }
}
