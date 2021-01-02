<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;
use DuAdmin\Assets\BootstrapTreeViewAsset;
use yii\helpers\Html;

class BootstrapTreeView extends Widget
{

    public function run()
    {
        BootstrapTreeViewAsset::register($this->view);
        $this->registerPlugin('treeview');
        return Html::tag('div', '', $this->options);
    }
}

