<?php

namespace DuAdmin\Core;

use DuAdmin\QrCode\WatermarkPng;
use BaconQrCode\Writer;
use Yii;
use yii\base\Action;

class QrAction extends Action
{

    public $content = '';

    public $watermark;

    public $watermark_size = 48;

    public $size = 100;

    public $margin = 4;

    public function init()
    {
        if (is_callable($this->content)) {
            $this->content = call_user_func($this->content);
        }
    }

    public function run()
    {
        $renderer = new WatermarkPng();
        $renderer->watermark_file = $this->watermark;
        $renderer->watermark_size = $this->watermark_size;
        $renderer->setHeight($this->size);
        $renderer->setWidth($this->size);
        $renderer->setMargin($this->margin);
        $writer =  new Writer($renderer);
        return Yii::$app->response->sendContentAsFile($writer->writeString($this->content), 'qr.png');
    }
}
