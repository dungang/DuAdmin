<?php

namespace Backend\Widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use DuAdmin\Models\Setting;
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\ArrayHelper;

class SettingSelection extends InputWidget
{

    /**
     * 参数设置模型
     *
     * @var Setting
     */
    public $model;

    public function run()
    {
        if ($items = $this->discoverItems()) {
            return $this->showDiscoverDropDownList($items);
        } else if ($this->model->valType === 'IMAGE') {
            return AjaxFileInput::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'value' => $this->value,
                'name' => $this->name,
                'options' => $this->options,
            ]);
        } else {

            return $this->showTextarea();
        }
    }

    private function showTextarea()
    {
        $options = array_merge([
            'rows' => 6
        ], $this->options);
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $options);
        } else {
            return Html::textarea($this->name, $this->value, options);
        }
    }

    private function showDiscoverDropDownList($items)
    {
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $items, $this->options);
        } else {
            return Html::dropDownList($this->name, $this->value, $items, $this->options);
        }
    }

    private function discoverItems()
    {
        if ($this->hasModel() && $this->model->name) {
            $items = Setting::find()->select([
                'title',
                'value'
            ])
                ->where([
                    'parent' => $this->model->name
                ])
                ->asArray()
                ->all();
            if ($items) {
                return ArrayHelper::map($items, 'value', 'title');
            }
        }
        return null;
    }
}