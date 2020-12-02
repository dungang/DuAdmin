<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;
use BaconQrCode\Writer;
use yii\helpers\FileHelper;
use DuAdmin\QrCode\WatermarkPng;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Common\ErrorCorrectionLevel;

/**
 *
 * @author dungang
 */
class QrWidget extends Widget
{

    public $savePic = true;

    public $size = 256;

    public $content;

    /**
     * 水印文件路径
     *
     * @var string
     */
    public $watermark;
    
    public $watermark_size = 48;

    public $htmlOptions = [];

    public function run()
    {
        if (empty($this->content))
            return null;
        if ($this->savePic) {
            return $this->createFile();
        } else {
            return $this->createString();
        }
    }

    /**
     *
     * @return \BaconQrCode\Writer
     */
    protected function getQrWriter()
    {
        $renderer = new WatermarkPng();
        $renderer->watermark_file = $this->watermark;
        $renderer->watermark_size = $this->watermark_size;
        $renderer->setHeight($this->size);
        $renderer->setWidth($this->size);
        return new Writer($renderer);
    }

    protected function createFile()
    {
        $qrDir = 'uploads/qrcode/';
        $abDir = \Yii::getAlias('@webroot') . '/' . $qrDir;
        if (! \is_dir($abDir)) {
            FileHelper::createDirectory($abDir);
        }
        $md5 = \md5($this->content);
        $file = $md5 . '.png';
        if (! \is_file($abDir . $file)) {
            $writer = $this->getQrWriter();
            $writer->writeFile($this->content, $abDir . $file, Encoder::DEFAULT_BYTE_MODE_ECODING, ErrorCorrectionLevel::Q);
        }
        return Html::img($qrDir . $file, $this->htmlOptions);
    }

    protected function createString()
    {
        $writer = $this->getQrWriter();
        return Html::img('data:image/png;base64,' . \base64_encode($writer->writeString($this->content, Encoder::DEFAULT_BYTE_MODE_ECODING, ErrorCorrectionLevel::Q)), $this->htmlOptions);
    }
}

