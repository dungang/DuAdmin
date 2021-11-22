<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;

class AgreementWidget extends InputWidget
{

    public $title;

    public $href;

    public function run()
    {
        $input = "";
        if ($this->hasModel()) {
            $input = Html::activeCheckbox($this->model, $this->attribute);
        } else {
            $input = Html::checkbox($this->name, $this->value);
        }
        return $input . Html::a( $this->title, $this->href, ['target' => '_blank','class'=>'text-primary']);
    }
}
