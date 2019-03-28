<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\Png;
use yii\helpers\FileHelper;

/**
 *
 * @author dungang
 */
class QrWidget extends Widget
{

    public $savePic = true;

    public $content;

    public $htmlOptions = [];

    public function run()
    {
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
        $renderer = new Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);
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
            $writer->writeFile($this->content, $abDir . $file);
        }
        return Html::img($qrDir . $file, $this->htmlOptions);
    }

    protected function createString()
    {
        $writer = $this->getQrWriter();
        return Html::img('data:image/png;base64,' .\base64_encode( $writer->writeString($this->content)), $this->htmlOptions);
    }
}

