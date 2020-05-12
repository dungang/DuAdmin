<?php
namespace app\mmadmin\widgets;

use yii\bootstrap\Widget;

class BatchLoad extends Widget
{

    public function run()
    {
        $this->registerPlugin('batchLoad');
    }
}

