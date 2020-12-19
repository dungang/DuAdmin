<?php
namespace DuAdmin\UI;

use yii\helpers\Html;

class ContainerWidthRow extends Layoutable
{
    
    public function run(){
        return Html::tag($this->tagName, Html::tag('div',$this->renderChilden(),['class'=>'row']), $this->options);
    }
}

