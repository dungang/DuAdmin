<?php

namespace app\mmadmin\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;

class AjaxFileInput extends InputWidget
{

    public $type = "image";

    public function run()
    {
        //$this->options['readonly'] = 'readonly';
        $this->options['data-type'] = $this->type;
        $this->options['data-token-url'] =  Url::to(['/site/upload-token']);
        $actionButton = '<span class="input-group-btn">
        <button class="btn btn-default" type="button">选择文件</button>
        <input type="file" style="display:none" />
      </span>';
        if ($this->hasModel()) {
            return Html::tag(
                'div',
                Html::activeTextInput($this->model, $this->attribute, $this->options) . $actionButton,
                ['class' => 'ajax-file-input input-group']
            );
        } else {
            return Html::tag(
                'div',
                Html::textInput($this->name, $this->value, $this->options) . $actionButton,
                ['class' => 'ajax-file-input input-group']
            );
        }
    }
}
