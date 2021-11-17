<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\Select2Asset;
use Yii;
use yii\bootstrap\InputWidget;
use yii\grid\GridViewAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class AdvanceSelect extends InputWidget
{

    /**
     * 必须手动自定
     */
    public $elementId = "advance-select";

    public $inputType = 'hidden';

    public $formArea = ['800px', '600px'];
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
        //提前注册
        GridViewAsset::register($this->view);
        Select2Asset::register($this->view);
        if (empty($this->addButtonLabel)) {
            $this->addButtonLabel = Yii::t('da', "Add");
        }
        $input = $this->renderInputHtml($this->inputType);
        //id input id;
        $this->view->registerJs($this->getJs("#" . $this->elementId, $this->id));
        return Html::tag('div', $this->render("advance-select", [
            'addButtonLabel' => $this->addButtonLabel,
            'input'          => $input,
            'id'             => $this->id, //input id
            'addButtonRoute' => $this->addButtonRoute,
            'selectWidth'    => $this->optionWidth,
            'pjaxId'         => $this->pjaxId,
        ]), ['id' => $this->elementId, 'role' => 'advance-select']);
    }

    public function getJs($selector, $id)
    {
        $options = Json::htmlEncode([
            'formTitle' => $this->addButtonLabel,
            'formArea' => $this->formArea,
            'inputType'     => $this->inputType,
            'resultLoadUrl' => Url::to($this->resultLoadRoute),
            'optionLoadUrl' => Url::to($this->optionLoadRoute),
            'pjaxId'        => $this->pjaxId,
            'onSubmitSuccess' => new JsExpression("function(data){
                return data.redirectUrl.id;
            }"),
        ]);
        return '$("' . $selector . '").advanceSelect(' . $options . ');';
    }
}
