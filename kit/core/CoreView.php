<?php

namespace app\kit\core;

use app\kit\hooks\ViewInitedHook;
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
