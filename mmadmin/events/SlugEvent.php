<?php

namespace app\mmadmin\events;

use yii\base\Event;

/**
 * 内容页事件
 * 主要是在获取页面内容
 */
class SlugEvent extends Event
{
    /**
     * @var bool whether the event is handled. Defaults to `false`.
     * When a handler sets this to be `true`, the event processing will stop and
     * ignore the rest of the uninvoked event handlers.
     */
    public $handled = false;

    /**
     * 获取内容的表示slug
     *
     * @var string
     */
    public $slug;

    /**
     * 对应的内容
     *
     * @var string
     */
    public $content;
}
