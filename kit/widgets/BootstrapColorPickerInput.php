<?php
namespace app\kit\widgets;

use yii\bootstrap\InputWidget;
use app\kit\assets\BootstrapColorPickerAsset;

/**
 * 调色盘
 * @author dungang
 */
class BootstrapColorPickerInput extends InputWidget
{

    public function run()
    {
        $this->options['class']='form-control';
        BootstrapColorPickerAsset::register($this->view);
        $this->registerPlugin('colorpicker');
        return $this->renderInputHtml('text');
    }
}

