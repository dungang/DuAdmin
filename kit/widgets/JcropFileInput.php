<?php
namespace app\kit\widgets;

use yii\bootstrap\Html;
use app\kit\assets\JcropAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\web\JsExpression;

/**
 * A lightweight and simple JavaScript, Jquery, YUI plugin to crop your avatar
 * https://github.com/hongkhanh/cropbox
 *
 * @author dungang
 */
class JcropFileInput extends InputWidget
{

    /**
     * 可选的切图参数的输入框
     *
     * @var string
     */
    public $cropInput;

    public $clientOptions = [];
    
    public $preview_h = 300;
    public $preview_w = 200;

    private $image_box_id;

    public function init()
    {
        parent::init();
        $this->clientOptions = ArrayHelper::merge([
            'boxWidth' => 300,
            'boxHeight' => 200,
            'onSelect' => new JsExpression("function(c){
                $('{$this->cropInput}').val(JSON.stringify(c));
            }")
        ], $this->clientOptions);
    }

    public function run()
    {
        JcropAsset::register($this->view);
        $html = $this->renderInputHtml();
        $html .= $this->renderImageBox();
        $this->addJsEvent();
        return $html;
    }

    protected function renderInputHtml()
    {
        if ($this->hasModel()) {
            return Html::activeFileInput($this->model, $this->attribute, $this->options);
        }
        return Html::fileInput($this->name, $this->value, $this->options);
    }

    protected function renderImageBox()
    {
        $this->image_box_id = $this->options['id'] . '-image-box';
        $content = '';
        if ($this->hasModel() && ($this->model->{$this->attribute})) {
            $content = Html::img($this->model->{$this->attribute}, [
                'width' => $this->preview_w,
                'height' => $this->preview_h
            ]);
        }
        return Html::tag('div', $content, [
            'id' => $this->image_box_id
        ]);
    }

    protected function addJsEvent()
    {
        $options = Json::encode($this->clientOptions);
        $this->view->registerJs(
            "$('#{$this->options['id']}').on('change',function(event){
                var file  = event.target.files[0];
                var reader = new FileReader();
                reader.addEventListener('load', function () {
                    var img = new Image();
                    img.src = this.result;
                    $('#{$this->image_box_id}').html(img);
                    $(img).Jcrop({$options});
                });
                reader.readAsDataURL(file);
            })");
    }
}

