<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Helpers\AppHelper;

/**
 * 默认轮播小部件
 * @author dungang
 *
 */
class DefaultFlashSwiper extends Widget
{

    /**
     * 轮播片的数量
     * @var integer
     */
    public $size;
    
    public function run()
    {
        return '<!--默认swiper是空内容-->';
    }

    public static function renderSwiper($options=[])
    {
        //系统配置的默认轮播
        $class = AppHelper::getSetting('system.flash.widget');
        if ($class) {
            if (class_exists($class)) {
                return call_user_func([$class,'widget'],$options);
            }
        }
        return static::widget($options);
    }
}

