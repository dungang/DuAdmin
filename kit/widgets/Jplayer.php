<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;
use app\kit\assets\JplayerAsset;
use yii\helpers\Html;

/**
 *
 * @author dungang
 */
class Jplayer extends Widget
{
    public function run(){
        JplayerAsset::register($this->view);
        $this->registerPlugin('jPlayer');
        return Html::tag('div','',$this->options);
    }
}

