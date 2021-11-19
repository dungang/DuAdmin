<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\LayerAsset;
use DuAdmin\Assets\NotifyAsset;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;

class LayerFormPage extends Widget
{


    /**
     * 父窗口的目标元素
     */
    public $parentWindowTargetHtmlId;

    public function init()
    {
        parent::init();
        if ($this->layerRequires()) {
            echo Html::beginTag('div', [
                'data-target-html-id' => $this->parentWindowTargetHtmlId,
                'role' => 'layer-form-page',
                'id' => $this->getId(),
            ]);
        }
    }

    public function run()
    {
        if ($this->layerRequires()) {
            echo Html::endTag('div');
            LayerAsset::register($this->view);
            $this->view->registerJs("$('#" . $this->getId() . "').layerFormPage();");
        }
    }

    protected function layerRequires()
    {
        return Yii::$app->request->get("_layer", false);
    }
}
