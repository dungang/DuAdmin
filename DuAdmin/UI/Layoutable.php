<?php
namespace DuAdmin\UI;

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
     *
     * @var string
     */
    public $tagName = 'div';

    /**
     * 布局的类css
     *
     * @var string
     */
    public $class = 'container';

    /**
     * 布局元素子元素
     *
     * @var Layoutable[]
     */
    public $children = [];
    
    /**
     * 是否支持ajaxform
     * @var boolean
     */
    public $enableAjaxForm = false;

    public function init()
    {
        parent::init();
        $this->initClass();
        if($this->enableAjaxForm) {
            $this->class .= ' enable-ajax-form';
        }
    }

    public function initClass()
    {}

    /**
     * 渲染子元素
     *
     * @return string
     */
    public function renderChilden()
    {
        return implode('', $this->children);
    }

    public function run()
    {
        return Html::tag($this->tagName, $this->renderChilden(), [
            'class' => $this->class
        ]);
    }
}

