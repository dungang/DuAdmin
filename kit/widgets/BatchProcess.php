<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;

class BatchProcess extends Widget
{

    public function run()
    {
        $this->registerPlugin('batchProcess');
    }
}

