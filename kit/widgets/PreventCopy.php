<?php
namespace app\kit\widgets;

use yii\base\Widget;
use app\kit\assets\AppAsset;

class PreventCopy extends Widget
{

    public function run()
    {
        AppAsset::register($this->view);
        $this->view->registerJs("$('div').on('selectstart',function(e){
            e.preventDefault();
            return false;
            })");
        $this->view->registerCss("*{ moz-user-select: -moz-none; -moz-user-select: none; -o-user-select:none; -khtml-user-select:none; -webkit-user-select:none; -ms-user-select:none; user-select:none; }");
    }
}

