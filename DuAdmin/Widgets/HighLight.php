<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Assets\HighLightAsset;

class HighLight extends Widget
{
    public function run(){
        HighLightAsset::register($this->view);
        //$this->view->registerJs(";hljs.initHighlightingOnLoad();");
        $this->view->registerJs("$('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
          });");
    }
}