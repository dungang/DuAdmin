<?php

namespace DuAdmin\Widgets;

use Yii;
use yii\bootstrap\InputWidget;
use yii\helpers\Json;
use yii\helpers\Url;

class AdvanceSelect extends InputWidget
{
    public $label;

    public $route;

    public function run()
    {
        if (empty($this->label)) {
            $this->label = Yii::t('da', "Add");
        }
        $this->view->registerJs($this->getJs("[role=advance-select]"));
        return $this->render("advance-select", [
            'label' => $this->label,
            'input' => $this->renderInputHtml("hidden"),
            'id' => $this->options['id']
        ]);
    }

    public function getJs($selector)
    {
        $options = Json::htmlEncode([
            'url' => Url::to($this->route),
            'pjaxId' => 'test-pajx-container',
        ]);
        return '$("' . $selector . '").advanceSelect(' . $options . ');';
    }
}
