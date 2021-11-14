<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\Select2Asset;
use Yii;
use yii\bootstrap\InputWidget;
use yii\helpers\Json;
use yii\helpers\Url;

class AdvanceSelect extends InputWidget
{
    public $inputType = 'hidden';
    /**
     * 添加按钮名称
     */
    public $addButtonLabel;

    /**
     * 添加的路由地址
     */
    public $addButtonRoute;

    /**
     * 选择结果列表数据加载的base路由
     */
    public $resultLoadRoute;

    /**
     * 下拉框选项的结果数据
     */
    public $optionLoadRoute;

    public $optionWidth = '220px';

    public $pjaxId = '';

    public function run()
    {
        Select2Asset::register($this->view);
        if (empty($this->addButtonLabel)) {
            $this->addButtonLabel = Yii::t('da', "Add");
        }
        $input = $this->renderInputHtml($this->inputType);
        $id = $this->options['id'];
        $this->view->registerJs($this->getJs("[role=advance-select]", $id));
        return $this->render("advance-select", [
            'addButtonLabel' => $this->addButtonLabel,
            'input'          => $input,
            'id'             => $id,
            'addButtonRoute' => $this->addButtonRoute,
            'selectWidth'    => $this->optionWidth,
            'pjaxId'         => $this->pjaxId,
        ]);
    }

    public function getJs($selector, $id)
    {
        $options = Json::htmlEncode([
            'inputType'     => $this->inputType,
            'resultLoadUrl' => Url::to($this->resultLoadRoute),
            'optionLoadUrl' => Url::to($this->optionLoadRoute),
            'pjaxId'        => $this->pjaxId,
        ]);
        return '$("' . $selector . '").advanceSelect(' . $options . ');';
    }
}
