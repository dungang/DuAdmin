<?php
namespace app\backend\widgets;

use yii\base\Widget;
use yii\helpers\Url;

/**
 *
 * @author dungang
 */
class StartCron extends Widget
{
    public function run(){
        $url = Url::to(['/cron/run']);
        $this->view->registerJs("$.get('${url}')");
    }
}

