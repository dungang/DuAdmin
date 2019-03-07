<?php
namespace app\kit\widgets;

use Yii;
use yii\base\Widget;

class AjaxContent extends Widget
{
    public function init(){
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }
    public function run(){
        $content = ob_get_clean();
        if (Yii::$app->request->isAjax) {
          return $content;
        }
    }
    
}

