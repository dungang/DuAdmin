<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Flash;
use DuAdmin\Widgets\BasePageBlock;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

class FlashCarouselBlock extends BasePageBlock
{

    public $intervel = 5000;

    public $wrap = 'true';

    public $pause = 'true';

    public $keyboard = 'true';


    public function renderPageBlock()
    {
        return Carousel::widget([
            'controls' => false,
            'items' => $this->formatItems(),
            'options' => [
                'class' => 'slide',
                'data-interval' => $this->intervel,
                'data-wrap' => $this->wrap,
                'data-pause' => $this->pause,
                'data-keyboard' => $this->keyboard,
            ]
        ]);
    }

    public function initQuery()
    {
        $this->query = Flash::find();
    }

    private function formatItems()
    {
        $items = $this->query->all();
        if ($items) {
            $items = array_map(function ($item) {
                return [
                    'content' => Html::img($item['pic']),
                    'caption' => Html::tag('h1', $item['name']),
                ];
            }, $items);
            return $items;
        }
        return [];
    }
}