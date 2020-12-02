<?php

namespace DuAdmin\Core;

use DuAdmin\Hooks\ViewInitedHook;
use yii\web\View;

/**
 * 重写视图
 * @author dungang<dungang@126.com>
 * date: 2019年9月20日
 */
class CoreView extends View
{

    public function init()
    {
        parent::init();
        ViewInitedHook::emit($this);
    }
}
