<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;

class ImagesUploadInput extends InputWidget
{

    public function run()
    {

        $content = $this->render("images-upload-input",[
            'input' => $this->renderInputHtml('hidden'),
        ]);
        return Html::tag('div', $content, ['class' => 'images-upload-input']);
    }
}
