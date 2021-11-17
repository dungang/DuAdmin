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

        $hidden = $this->renderInputHtml("hidden");
        return $hidden . $this->renderCheckboxList();
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
        return Html::checkboxList('', $selection, $this->items);
    }
}
