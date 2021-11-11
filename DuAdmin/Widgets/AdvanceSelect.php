<?php

namespace DuAdmin\Widgets;

use Yii;
use yii\bootstrap\InputWidget;

class AdvanceSelect extends InputWidget
{
    public $label;

    public function run()
    {
        if (empty($this->label)) {
            $this->label = Yii::t('da', "Add");
        }
        return $this->render("advance-select", [
            'label' => $this->label,
            'content' => $this->renderInputHtml("hidden")
        ]);
    }
}
