<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;
use DuAdmin\Assets\FullCalendarAsset;
use yii\bootstrap\Html;

/**
 * 完整日历小部件
 * @author dungang<dungang@126.com>
 * @since date: 2019年10月17日
 */
class FullCalendar extends Widget
{

    public function run()
    {
        FullCalendarAsset::register($this->view);
        $this->registerPlugin('fullCalendar');
        return Html::tag('div','',$this->options);
    }
}

