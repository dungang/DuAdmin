<?php


namespace Addons\Cms\Assets;


use DuAdmin\Assets\DuAdminAsset;
use DuAdmin\Assets\JqueryUIAsset;
use DuAdmin\Assets\PoplineEditorAsset;

class LiveEditorAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@Addons/Cms/Resource/dist';

    public $js = [
        'js/cms-live-editor.js'
    ];
    public $css = [
        'css/cms-live-editor.css'
    ];

    public $depends = [

        DuAdminAsset::class,
        JqueryUIAsset::class,
        PoplineEditorAsset::class
    ];

    public $publishOptions = [
        'publishDir' => 'cms'
    ];
}