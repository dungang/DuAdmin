<?php
namespace Addons\Cms\Assets;

use DuAdmin\Assets\JqueryUIAsset;

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
        JqueryUIAsset::class,
    ];

    public $publishOptions = [
        'publishDir' => 'cms'
    ];
}