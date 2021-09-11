<?php
namespace DuAdmin\UI;

use yii\helpers\Html;

/**
 * 参考adminlte box 样式
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-19
 */
class Box extends Layoutable
{

    public $class = 'box';

    /**
     * 样式
     * success,warning,info,danger,default,primary
     *
     * @var string
     */
    public $style = 'default';

    public $weight = 'solid';

    public $title = '';

    public $headWidthBorder = true;

    public $raduis = 'backend-radius';

    public function initClass()
    {
        if ($this->style) {
            $this->class .= ' box-' . $this->style;
        }
        if ($this->weight) {
            $this->class .= ' box-' . $this->weight;
        }
        if( $this->raduis) {
            $this->class .= ' ' . $this->raduis;
        }
    }

    public function renderChilden()
    {
        $children = parent::renderChilden();
        return $this->renderHead() . $this->renderBody($children);
    }

    public function renderHead()
    {
        if ($this->title) {

            $classes = [
                'box-header'
            ];
            if ($this->headWidthBorder) {
                $classes[] = 'width-border';
            }
            return Html::tag('div', $this->title, [
                'class' => implode(' ', $classes)
            ]);
        }
        return '';
    }

    public function renderBody($content)
    {
        return Html::tag('div', $content, [
            'class' => 'box-body'
        ]);
    }
}

