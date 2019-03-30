<?php
namespace app\kit\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 *
 * @author dungang
 */
class FileInput extends InputWidget
{

    protected $_value;

    public $thumbSufix = '_thumb.png';
    
    public function run(){
        return $this->renderInputHtml('file');
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\widgets\InputWidget::renderInputHtml()
     */
    protected function renderInputHtml($type)
    {
        return parent::renderInputHtml($type) . $this->renderFileInfo();
    }

    protected function renderFileInfo()
    {
        if ($type = $this->fileType()) {
            if ($type == 'image') {
                return Html::img($this->_value . $this->thumbSufix, [
                    'width' => '300',
                    'height' => '200',
                    'class'=>'thumbnail'
                ]);
            } else {
                return Html::tag('p', $this->_value, [
                    'class' => 'text-muted'
                ]);
            }
        }
        return '';
    }

    protected function fileType()
    {
        $this->_value = $this->value;
        if ($this->hasModel()) {
            $this->_value = $this->model->{$this->attribute};
        }
        if ($this->_value) {
            if (\preg_match('#\.(png|jpg|gif)$#', $this->_value)) {
                return 'image';
            }
            return 'file';
        }
        return null;
    }
}

