<?php

namespace Backend\Widgets;

use DuAdmin\Models\DictData;
use DuAdmin\Models\Setting;
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class SettingSelection extends InputWidget {

    /**
     * 参数设置模型
     *
     * @var Setting
     */
    public $model;

    public function run() {
        if ( $items = $this->discoverItems() ) {
            return $this->showDiscoverDropDownList( $items );
        } else if ( $this->model->valType === Setting::TYPE_BOOL ) {
            return $this->showDiscoverDropDownList( DictData::getDataLabels("yes_or_no"));
        } else if ( $this->model->valType === Setting::TYPE_IMAGE ) {
            return AjaxFileInput::widget( [
                    'model'     => $this->model,
                    'attribute' => $this->attribute,
                    'value'     => $this->value,
                    'name'      => $this->name,
                    'options'   => $this->options,
                    'clip'      => 'false'
                ] );
        } else {

            return $this->showTextarea();
        }
    }

    private function showTextarea() {
        $options = array_merge( [
            'rows' => 6
            ], $this->options );
        if ( $this->hasModel() ) {
            return Html::activeTextarea( $this->model, $this->attribute, $options );
        } else {
            return Html::textarea( $this->name, $this->value, $options );
        }
    }

    private function showDiscoverDropDownList( $items ) {
        if ( $this->hasModel() ) {
            return Html::activeDropDownList( $this->model, $this->attribute, $items, $this->options );
        } else {
            return Html::dropDownList( $this->name, $this->value, $items, $this->options );
        }
    }

    private function discoverItems() {
        if ( $this->hasModel() && $this->model->dictType ) {
            return DictData::getDataLabels( $this->model->dictType );
        }
        return null;
    }

}
