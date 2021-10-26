<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;

class CleanDebugToolbar extends Widget
{

    public function run()
    {
        $this->view->registerCss("#yii-debug-toolbar{display:none !important;}");
    }
}
