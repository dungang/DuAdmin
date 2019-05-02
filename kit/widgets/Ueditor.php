<?php

namespace app\kit\widgets;

use yii\widgets\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\kit\assets\UeditorAsset;
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Json;

class Ueditor extends InputWidget
{
    public $serverUrl = ['/backend/attachment/ueditor-upload'];

    //配置选项，参阅Ueditor官网文档(定制菜单等)
    public $clientOptions = [];

    public $toolBars = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        $options = [
            'serverUrl' => Url::to($this->serverUrl),
            'initialFrameWidth' => '100%',
            'initialFrameHeight' => '400',
            'autoFloatEnabled'=>true,
            'topOffset'=> 50,
            'lang' => (strtolower(\Yii::$app->language) == 'en-us') ? 'en' : 'zh-cn',
        ];
        $baseBars = [
            'fullscreen', 'source', 'undo', 'redo', '|',
            'fontsize',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
            'forecolor', 'backcolor', '|',
            'lineheight', '|',
            'indent', '|',
        ];
         $this->clientOptions['toolbars']=[array_merge($baseBars,$this->toolBars)];

        $this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
        parent::init();
    }

    public function run()
    {
        $this->registerClientScript();
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['id' => $this->id]);
        } else {
            return Html::textarea($this->name, $this->value, ['id' => $this->id]);
        }
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        $assets = UeditorAsset::register($this->view);
        $this->clientOptions['UEDITOR_HOME_URL'] = $assets->baseUrl.'/';
        $clientOptions = Json::encode($this->clientOptions);
        $script = "UE.delEditor('" . $this->id . "');UE.getEditor('" . $this->id . "', " . $clientOptions . ")";
        $this->view->registerJs($script, View::POS_READY);
    }

}