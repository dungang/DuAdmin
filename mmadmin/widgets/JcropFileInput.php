<?php
namespace app\mmadmin\widgets;

use yii\bootstrap\Html;
use app\mmadmin\assets\JcropAsset;
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

    private $crop_input_id;

    public function run()
    {
        JcropAsset::register($this->view);
        $html = $this->renderFileInputHtml();
        $html .= $this->renderImageBox();
        $ratio = $this->preview_w / $this->preview_h;
        $this->clientOptions = ArrayHelper::merge([
            'boxHeight' => $this->preview_h,
            'boxWidth' => $this->preview_w,
            'setSelect' => [
                100,
                100,
                200,
                200
            ],
            'aspectRatio' => $ratio,
            'onSelect' => new JsExpression("function(c){
                $('#{$this->crop_input_id}').val(JSON.stringify(c));
            }")
        ], $this->clientOptions);
        $this->addJsEvent();
        return $html;
    }



    protected function renderFileInputHtml()
    {
        $html = '';
        if ($this->hasModel()) {
            if (!isset($this->field->form->options['enctype'])) {
                $this->field->form->options['enctype'] = 'multipart/form-data';
            }
            $this->crop_input_id = $this->attribute . '_crop';
            $html = Html::hiddenInput($this->crop_input_id, null, ['id' => $this->crop_input_id]);
            $html .= Html::activeFileInput($this->model, $this->attribute, $this->options);
        } else {
            $this->crop_input_id = $this->this->crop_input_id . '_crop';
            $html = Html::hiddenInput($this->crop_input_id, null, ['id' => $this->crop_input_id]);
            $html .= Html::fileInput($this->name, $this->value, $this->options);
        }
        return $html;
    }

    protected function renderImageBox()
    {
        $this->image_box_id = $this->options['id'] . '-image-box';
        $content = '';
        if ($this->hasModel() && ($this->model->{$this->attribute})) {
            $content = Html::img($this->model->{$this->attribute}, [
                'width'=>'100%'
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
            })"
        );
    }
}
