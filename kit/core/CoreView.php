<?php
namespace app\kit\core;

use yii\web\View;
use app\kit\models\EventHandler;

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
        EventHandler::registerLevel($this, 'View');
    }
}

