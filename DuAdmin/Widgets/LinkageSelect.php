<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;

class LinkageSelect extends InputWidget
{
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
    public $parentSelectId;

    /**
     * 父的参数名称
     */
    public $parentName='pid';

    /**
     * 数据请求的路由
     */
    public $route = ['/site/dict'];

    public function run()
    {
        $config = [
            'data-linkage' => true,
            'data-queue'   => implode(',', array_map(function ($field) {
                return '#' . $field;
            }, $this->subFields)),
            'data-parent-id' => $this->parentValue,
            'data-param'     => $this->parentName,
            'data-url'       => Url::to($this->route),
        ];

        if ($this->hasModel()) {
            $config['id'] = $this->attribute;
            $config['value'] = $this->model[$this->attribute];
            return Html::activeDropDownList($this->model, $this->attribute, [], $config);
        } else {
            $config['id'] = $this->name;
            $config['value'] = $this->value;
            return Html::dropDownList($this->name, $this->value, [], $config);
        }
    }
}
