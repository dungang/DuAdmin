<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\NestableAsset;
use yii\bootstrap\Widget;
use yii\helpers\Html;
/**
 * 树列表
 * http://www.niftyadmin.cn/misc-nestable-list.html
 */
class TreeList extends Widget
{
    public $items = [];

    public $rowRender;

    public $options = ['class'=>'dd'];

    public function run()
    {
        NestableAsset::register($this->view);
        $this->registerPlugin('nestable');
        return Html::tag('div',$this->renderChildren($this->items),$this->options);
    }

    private function renderChildren($items)
    {
        $childEls = '';
        foreach ($items as $item) {
            $childEls .= $this->renderItem($item);
        }
        return Html::tag('ol', $childEls, ['class' => 'dd-list']);
    }

    private function renderItem($item)
    {
        if(is_callable($this->rowRender)) {
            $content = call_user_func($this->rowRender,$item);
        } else {
            $content = '';
        }
        $itemInfo = Html::tag('div',$content, ['class' => 'dd-handle dd-bg dd-anim']);
        if (isset($item['childer']) && is_array($item['childer'])) {

            $itemInfo .= $this->renderChildren($item['children']);
        }
        return Html::tag('li', $itemInfo, ['class' => 'dd-item', 'data-id' => $item['id']]);
    }
}
