<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Helpers\AppHelper;

class DefaultFlashSwiper extends Widget
{

    
    public function run()
    {
        return '<!--默认swiper是空内容-->';
    }

    public static function renderSwiper($options=[])
    {
        $class = AppHelper::getSetting('system.flash.widget');
        if ($class) {
            if (class_exists($class)) {
                return call_user_func([$class,'widget'],$options);
            }
        }
        return static::widget($options);
    }
}

