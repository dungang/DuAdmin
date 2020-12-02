<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;

class BatchLoad extends Widget
{

    public function run()
    {
        $this->registerPlugin('batchLoad');
    }
}

