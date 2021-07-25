<?php


namespace Addons\Cms\PageBlock;


use yii\helpers\Html;

abstract class PlaceHolderWidget extends \yii\base\Widget
{

    /**
     * @var int
     */
    public $pageBlockId;

    protected abstract function renderBlock();

    public function run()
    {
        return Html::tag( 'div', $this->renderBlock(),
            [
                'class'              => 'du-live-block',
                'data-page-block-id' => $this->pageBlockId
            ] );
    }
}