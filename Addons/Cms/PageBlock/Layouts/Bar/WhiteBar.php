<?php


namespace Addons\Cms\PageBlock\Layouts\Bar;

use Addons\Cms\PageBlock\BaseBlockWidget;
use yii\helpers\Html;

/**
 * 白色背景占位条
 * Class WhiteBar
 * @package Addons\Cms\PageBlock\Layouts\Bar
 */
class WhiteBar extends BaseBlockWidget
{
    public $type = 'layout';
    public $basePath = __DIR__;
    public $iconFile = 'bar.png';

    public function prepareLiveCode(){
        return Html::tag('div','',['style'=>'height:30px;background-color:white;']);
    }
}