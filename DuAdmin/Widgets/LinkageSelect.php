<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;
use yii\web\View;

class LinkageSelect extends InputWidget
{
    public $type = 'child';
    /**
     * 子集的都写上
     * var array $subFields
     */
    public $subFields = [];

    /**
     * 父的参数的值，和 select方式二选一
     */
    public $parentValue;


    /**
     * 父的参数的值，通过标签select
     */
    public $parentSelectName;

    /**
     * 父的参数名称
     */
    public $parentName = 'pid';

    /**
     * 数据请求的路由
     */
    public $route = ['/site/dict'];

    public function run()
    {

        $this->view->registerJs("$(document).linkageSelect();",View::POS_READY,"linkageSelect");

        $view_id = Html::getViewInputId();

        $config = [
            'data-linkage' => $this->type,
            'data-queue'   => implode(',', array_map(function ($field) use ($view_id) {
                return '#' . $view_id . '-' . strtolower($field);
            }, $this->subFields)),
            'data-parent-id' => $this->parentValue,
            'data-parent' => $this->parentSelectName ? '#' . $view_id . '-' . strtolower($this->parentSelectName) : null,
            'data-param'     => $this->parentName,
            'data-url'       => Url::to($this->route),
            'class' => 'form-control'
        ];

        if ($this->hasModel()) {
            $config['id'] = Html::getInputId($this->model, $this->attribute);
            $config['value'] = $this->model[$this->attribute];
            return Html::activeDropDownList($this->model, $this->attribute, [], $config);
        } else {
            $config['id'] = $this->name;
            $config['value'] = $this->value;
            return Html::dropDownList($this->name, $this->value, [], $config);
        }
    }
}
