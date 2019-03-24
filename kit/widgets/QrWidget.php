<?php
namespace app\kit\widgets;

use app\kit\assets\QrAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 *
 * @author dungang
 */
class QrWidget extends Widget
{
    public $content;
    
    public $htmlOptions=[];
    
    public function run(){
        QrAsset::register($this->view);
        $id = $this->getId();
        $this->view->registerJs("$('#{$id}').qrcode('{$this->content}')");
        return Html::tag('div','',ArrayHelper::merge(['id'=>$id], $this->htmlOptions));
    }
}

