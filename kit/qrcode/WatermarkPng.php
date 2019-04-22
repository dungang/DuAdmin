<?php
namespace app\kit\qrcode;

use BaconQrCode\Renderer\Image\Png;

/**
 * 带水印的二维码
 *
 * @author dungang
 */
class WatermarkPng extends Png
{

    public $watermark_file;

    public $watermark_size = 48;

    protected function getWatermark()
    {
        if ($this->watermark_file && \is_file($this->watermark_file)) {
            $image = \file_get_contents($this->watermark_file);
            return \imagecreatefromstring($image);
        }
        return false;
    }

    protected function drawWatermarkCenter()
    {
        if ($watermark = $this->getWatermark()) {
            $water_width = imagesx($watermark);
            $water_height = imagesy($watermark);
            if (empty($this->watermark_size)) {
                $this->watermark_size = $water_width;
            }
            $water_qr_height = $water_height * $this->watermark_size / $water_height;
            $waterX = $this->finalWidth / 2 - $this->watermark_size / 2;
            $waterY = $this->finalHeight / 2 - $water_qr_height / 2;
            imagecopyresampled($this->image, $watermark, (int) $waterX, (int) $waterY, 0, 0, $this->watermark_size, $water_qr_height, $water_width, $water_height);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \BaconQrCode\Renderer\Image\Png::getByteStream()
     */
    public function getByteStream()
    {
        $this->drawWatermarkCenter();
        return parent::getByteStream();
    }
}

