<?php

namespace DuAdmin\Widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class CheckboxListInput extends InputWidget
{

    /**
     * 是否有全选的选项
     */
    public $hasAllItem = true;

    /**
     * 初始化的时候默认选择全部
     */
    public $initSelectedAll = true;

    public $items = [];

    public function run()
    {
        return $this->renderCheckboxList();
    }

    public function renderCheckboxList()
    {
        if ($this->hasModel()) {
            $val = $this->model[$this->attribute];
        } else {
            $val = $this->value;
        }
        if ($val) {
            $selection = explode(",", $val);
        } else {
            $selection = [];
        }

        if ($this->hasAllItem) {
            $this->items = ArrayHelper::merge(['all' => '全选'], $this->items);
        }

        $lines = [];
        foreach ($this->items as $value => $label) {
            $checked = ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string)$value, $selection, false);
            $lines[] = Html::checkbox(null, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
            ]);
        }

        $hidden = $this->renderInputHtml("hidden");
        $selectionId = $this->getId() . '-checkbox-selection';
        $this->view->registerJs("$('#" . $selectionId . "').checkboxSelection();");
        return Html::tag('div', $hidden . implode("\n", $lines), ['role' => 'checkbox-selection', 'id' => $selectionId]);
    }
}
