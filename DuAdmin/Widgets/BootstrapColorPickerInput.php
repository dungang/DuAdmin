<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\InputWidget;
use DuAdmin\Assets\BootstrapColorPickerAsset;

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

