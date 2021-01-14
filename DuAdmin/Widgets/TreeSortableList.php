<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\NestableAsset;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\ArrayHelper;

/**
 * 树列表
 * http://www.niftyadmin.cn/misc-nestable-list.html
 * https://github.com/dbushell/Nestable
 */
class TreeSortableList extends Widget
{

    public $showHeader = false;

    /**
     * 树的深度 默认是2
     *
     * @var integer
     */
    public $maxDepth = 2;

    /**
     * 树的ID，不同的树互环子元素需要指定groupId(每个树id不同)
     *
     * @var integer
     */
    public $group = 0;

    /**
     * 元素是否可以移动
     *
     * @var boolean
     */
    public $enableSortable = true;

    /**
     * 树的元素
     *
     * @var array
     */
    public $items = [];

    /**
     * 多选的字段名称
     *
     * @var string
     */
    public $checkName = null;

    public $url = [
        'sorts'
    ];

    /**
     * 渲染元素的行
     *
     * @var callable
     */
    public $rowRender;

    /**
     * 是否支持操作的按钮
     *
     * @var boolean|array
     */
    public $actionColumn = [];

    public $options = [
        'class' => 'dd'
    ];

    public $keyName = 'id';

    public function run()
    {
        $this->clientOptions['group'] = $this->group;
        $this->clientOptions['maxDepth'] = $this->maxDepth;
        NestableAsset::register($this->view);
        if ($this->enableSortable) {
            $this->registChangeEvent();
            $this->registerPlugin('nestable');
        }
        if ($this->items) {
            $this->listToTree();
            return Html::tag('div', $this->renderChildren($this->items), $this->options);
        } else {
            return Html::tag('div', Html::tag('div', \Yii::t('yii', 'No results found.'), ['class' => 'empty']), $this->options);
        }
    }

    private function renderChildren($items)
    {
        $childEls = '';
        foreach ($items as $index => $item) {
            $key = $item[$this->keyName];
            $childEls .= $this->renderItem($item, $key, $index);
        }
        return Html::tag('ol', $childEls, [
            'class' => 'dd-list dd-list-handle-btn'
        ]);
    }

    private function renderItem($item, $key, $index)
    {
        if (is_callable($this->rowRender)) {
            $content = call_user_func($this->rowRender, $item);
        } else {
            $content = '';
        }
        // 渲染 多选checkbox
        if ($this->checkName) {
            $checked = false;
            if (isset($item['checked'])) {
                $checked = $item['checked'];
            }
            $name = 'id[]';
            if (is_string($this->checkName)) {
                $name = $this->checkName . '[]';
            }
            $selection = '<span class="tree-check-box">' . Html::checkbox($name, $checked, [
                'value' => $item['id']
            ]) . '</span>';
            $content = $selection . $content;
        }
        // 渲染 action 按钮
        if (is_array($this->actionColumn)) {

            $actionColumn = ArrayHelper::merge([
                'class' => '\DuAdmin\Grids\ActionColumn',
                'tagName' => 'div',
                'enableDropDown' => false
            ], $this->actionColumn);
            /* @var \DuAdmin\Grids\ActionColumn $column  */
            $column = \Yii::createObject($actionColumn);
            $content .= $column->renderDataCell($item, $key, $index);
        }

        $itemInfo = "<div class='dd-handle dd-handle-btn  dd-bg'></div><div class='dd-content bord-all dd-bg'>" . $content . "</div>";

        if (isset($item['children']) && is_array($item['children'])) {

            $itemInfo .= $this->renderChildren($item['children']);
        }

        return Html::tag('li', $itemInfo, [
            'class' => 'dd-item dd-anim',
            'data-id' => $item['id'],
            'data-pid' => $item['pid']
        ]);
    }

    private function listToTree()
    {
        // $this->items = array_map(function($item){
        // return $item->toArray();
        // },$this->items);
        // $this->items = array_map(function ($item) {
        //     if (!isset($item['pid'])) {
        //         $item['pid'] = '0';
        //     }
        //     return $item;
        // }, $this->items);
        $this->items = AppHelper::listToTree($this->items, 'id', 'pid', 'children');
    }

    private function registChangeEvent()
    {
        $this->clientEvents['change'] = $this->onChange();
    }

    private function onChange()
    {
        $url = Url::to($this->url);
        return <<<UPDATE
function(e,target){
    var list = $(this);
    var serializeData = JSON.stringify(list.data('serialize'));
    var sorts = list.nestable("serialize");
    if(serializeData == JSON.stringify(sorts)) {
        console.log('list no change');    
    } else {
        list.data('serialize',sorts);
        $.post('{$url}',{sorts:sorts},function(data){
            //console.log(data);
        });
    }
}
UPDATE;
    }
}