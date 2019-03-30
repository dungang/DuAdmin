<?php
namespace app\kit\widgets;

use yii\helpers\Html;
use yii\base\Widget;

/**
 *
 * @author dungang
 */
class FileInfo extends Widget
{

    public $value;

    public $width = 300;

    public $height = 200;

    public $thumbSufix = '_thumb.png';

    public function run()
    {
        return $this->renderFileInfo();
    }

    protected function renderFileInfo()
    {
        if ($type = $this->fileType()) {
            if ($type == 'image') {
                return Html::img($this->value . $this->thumbSufix, [
                    'width' => '300',
                    'height' => '200',
                    'class' => 'thumbnail'
                ]);
            } else {
                return Html::tag('p', $this->value, [
                    'class' => 'text-muted'
                ]);
            }
        }
        return '';
    }

    protected function fileType()
    {
        if ($this->value) {
            if (\preg_match('#\.(png|jpg|gif)$#', $this->value)) {
                return 'image';
            }
            return 'file';
        }
        return null;
    }
}

