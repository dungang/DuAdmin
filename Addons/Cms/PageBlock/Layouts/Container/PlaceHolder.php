<?php


namespace Addons\Cms\PageBlock\LayoutContainer;


use Addons\Cms\PageBlock\PlaceHolderWidget;
use yii\helpers\Html;

/**
 * bootstrap container
 * Class PlaceHolder
 * @package Addons\Cms\PageBlock\LayoutContainer
 */
class PlaceHolder extends PlaceHolderWidget
{

    protected function renderBlock()
    {
        return Html::tag( 'div',
            Html::tag( 'div', '',
                ['class' => 'row'] ),
            ['class' => 'container'] );
    }
}