<?php

namespace app\mmadmin\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;

class SelectBox extends InputWidget
{
    public $boxOptions = [];

    public $sourceItems = [];

    public $targetItems = [];

    public function run()
    {
        $this->options['class'] = 'table table-bordered';
        $this->boxOptions = ArrayHelper::merge([
            'multiple' => true,
            'class' => 'form-control'
        ], $this->boxOptions);

        $this->registerPlugin('selectBox');

        return $this->render('select-box', [
            'widget' => $this,
            'target' => $this->renderTarget(),
        ]);
    }

    public function renderTarget()
    {
        $options = $this->boxOptions;
        $options['id'] = $this->options['id'] . '-target';
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->targetItems, $options);
        } else {
            return Html::dropDownList($this->name, $this->value, $this->targetItems, $options);
        }
    }
}
