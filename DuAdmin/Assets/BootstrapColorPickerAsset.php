<?php
namespace DuAdmin\Assets;


use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class BootstrapColorPickerAsset extends AssetBundle
{
    public $baseUrl = '@web/third/colorpicker';
    
    public $css = [
        'css/bootstrap-colorpicker.min.css'
    ];
    
    public $js = [
        'js/bootstrap-colorpicker.min.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

