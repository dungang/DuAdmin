<?php

namespace app\mmadmin\widgets;

use yii\base\Widget;
use yii\web\View;

class H5App extends Widget
{

    public function run()
    {
        $this->view->registerJs($this->js(), View::POS_END);
    }

    public function js()
    {
        return <<<JS

function resetRem() {
    var html = document.querySelector("html");
    var oWidth = document.body.clientWidth || document.documentElement.clientWidth;
    //参考375校准
    var size = parseInt(oWidth) / 10;
    html.setAttribute('style', 'font-size:' + size.toFixed(4) + "px");
}
var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
window.onload = resetRem;
window.addEventListener(resizeEvt, resetRem, false);

JS;
    }
}
