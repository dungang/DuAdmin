<?php


namespace Addons\Cms\PageBlock\Layouts\Bar;


use Addons\Cms\PageBlock\BaseBlockWidget;
use yii\helpers\Html;

class Bar extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'bar.png';

    public function prepareLiveCode(){
        return Html::tag('div','',['style'=>'height:30px;']);
    }
}