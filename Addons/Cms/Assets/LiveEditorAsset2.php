<?php


namespace Addons\Cms\Assets;


use DuAdmin\Assets\JqueryUIAsset;
use DuAdmin\Assets\PoplineEditorAsset;

class LiveEditorAsset2 extends \yii\web\AssetBundle
{
    public $sourcePath = '@Addons/Cms/Resource/dist';

    public $js = [
        'js/cms-live-editor2.js'
    ];
    public $css = [
        'css/cms-live-editor2.css'
    ];

    public $depends = [
        JqueryUIAsset::class,
        PoplineEditorAsset::class
    ];

    public $publishOptions = [
        'publishDir' => 'cms'
    ];
}