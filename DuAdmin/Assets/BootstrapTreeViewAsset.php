<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class BootstrapTreeViewAsset extends AssetBundle
{
    public $baseUrl = '@web/third/bootstrap-treeview/dist';
    
    public $css = [
        'bootstrap-treeview.min.css'
    ];
    
    public $js = [
        'bootstrap-treeview.min.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

