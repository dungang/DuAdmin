<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;

class LongPoll extends Widget
{

    public function run()
    {
        $this->registerPlugin('longpoll');
    }
}

