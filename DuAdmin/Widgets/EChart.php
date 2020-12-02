<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Assets\EChartAsset;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * 生成Bar
 *
 * @author dungang
 *        
 */
class EChart extends Widget
{

    public $clientOptions;

    public $options = [];

    public function run()
    {
        EChartAsset::register($this->view);
        $echartOptions = Json::htmlEncode($this->clientOptions);
        $this->options['id'] = $id = $this->getId();
        $this->view->registerJs("new Chart(document.getElementById('$id').getContext('2d'),$echartOptions);");
        return Html::tag('canvas', '', $this->options);
    }
}

