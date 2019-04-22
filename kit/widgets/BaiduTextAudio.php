<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\web\JsExpression;
use app\kit\thirds\BaiduTextAudioClient;

/**
 *
 * @author dungang
 */
class BaiduTextAudio extends Widget
{

    public $text;

    public function run()
    {
        $client = new BaiduTextAudioClient();
        
        $this->view->registerJs(new JsExpression("speckText('" . $client->toUrl($this->text) . "')"));
    }
}

