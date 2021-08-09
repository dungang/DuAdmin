<?php
namespace Addons\Cms\Assets;

class LiveEditorCssAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@Addons/Cms/Resource/dist';

    public $css = [
        'css/cms-live-editor2.css'
    ];

    public $publishOptions = [
        'publishDir' => 'cms'
    ];
}