<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;

abstract class BasePageBlock extends Widget
{

    /**
     * page block model
     *
     * @var \DuAdmin\Models\PageBlock
     */
    public $model;

    public final function run()
    {
        if ($this->model->background) {
            $this->options['style'] = 'background:' . $this->model->background;
        }
        return Html::tag('div', $this->renderPageBlock(), $this->options);
    }

    abstract function renderPageBlock();
}

