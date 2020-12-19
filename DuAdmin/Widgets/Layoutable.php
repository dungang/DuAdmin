<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * 布局基础类
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-19
 */
abstract class Layoutable extends Widget
{

    /**
     * 布局的标签
     * @var string
     */
    public $tagName = 'div';

    /**
     * 布局的类css
     * @var string
     */
    public $class = 'container';

    /**
     * 布局元素子元素
     *
     * @var Layoutable[]
     */
    public $children = [];

    public function init()
    {
        $this->options['class'] = $this->class;
    }

    public function run()
    {
        $content = '';
        foreach ($this->children as $child) {
            $content .= $child->run();
        }
        return Html::tag($this->tagName, $content, $this->options);
    }
}

