<?php

namespace app\mmadmin\storage;

use yii\helpers\FileHelper;
use yii\imagine\BaseImage;
use app\mmadmin\uploader\ConfigWidget;

/**
 *
 * @author dungang
 */
class LocalDriver extends IDriver
{

    protected $webroot;

    public function init()
    {
        $this->webroot = \Yii::getAlias("@webroot");
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\storage\IDriver::initWritePath()
     */
    public function initWritePath($fileType)
    {
        $dir = parent::initWritePath($fileType);
        $path = $this->webroot . '/' . $dir;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        return $dir;
    }

    protected function initOldFilePath($filePath)
    {
        $path = \dirname($this->webroot . '/' . $filePath);
        if (!\is_dir($path)) {
            FileHelper::createDirectory($path);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @param \yii\web\UploadedFile $file
     * @see \app\mmadmin\storage\IDriver::write()
     */
    public function write($file, $fileType, $filePath = NULL, $resize = NULL)
    {
        if ($filePath == null) {
            $filePath = $this->getWriteFilePath($file, $fileType);
        } else {
            $this->initOldFilePath($filePath);
        }
        if ($resize) {
            if ($resize['x'] === NULL || $resize['y'] === NULL) {
                $this->thumbnail(self::THUMBNAIL_FROM_TMP, $filePath, $file, '', $resize['width'], $resize['height'], $resize['mode']);
            } else {
                $this->crop($filePath, $file, '', $resize['width'], $resize['height'], $resize['x'], $resize['y']);
            }
        } else {
            $targetFile = $this->webroot . '/' . $filePath;
            //不立刻删除临时文件，方便后面的程序还可以使用临时文件
            $file->saveAs($targetFile, false);
        }

        return $filePath;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\storage\IDriver::thumbnail()
     */
    public function thumbnail($thumbnail_source, $filePath, $file, $suffix, $width, $height, $mode)
    {
        $targetFile = $this->webroot . '/' . $filePath;
        if ($thumbnail_source === self::THUMBNAIL_FROM_TMP) {
            $thumbnail = BaseImage::thumbnail($file->tempName, $width, $height, $mode);
        } else {
            $thumbnail = BaseImage::thumbnail($targetFile, $width, $height, $mode);
        }
        $thumbPath = $targetFile . $suffix;
        $thumbnail->save($thumbPath, $this->getImageQualities());
        return $thumbPath;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\storage\IDriver::crop()
     */
    public function crop($filePath, $file, $suffix, $width, $height, $x, $y, $final_width = null, $final_height = null)
    {
        $targetFile = $this->webroot . '/' . $filePath;
        $crop = BaseImage::crop($file->tempName, $width, $height, [
            $x,
            $y
        ]);
        if ($final_width && $final_height) {
            $crop = BaseImage::resize($crop, $final_width, $final_height, true, true);
        }
        $cropPath = $targetFile . $suffix;
        $crop->save($cropPath, $this->getImageQualities());
        return $cropPath;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\storage\IDriver::delete()
     */
    public function delete($filename)
    {
        if (!\parse_url($filename, PHP_URL_SCHEME)) {
            $targetFile = $this->webroot . '/' . $filename;
            FileHelper::unlink($targetFile);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\storage\IDriver::configWidget()
     */
    public function configWidget()
    {
        ConfigWidget::widget();
    }

    /**
     * 生成验证token和文件key(无后缀)
     *
     * @param string $fileType 前端传递的文件类型，默认是image
     * @return array
     */
    public function generateUploadToken($fileType = 'image')
    {
        return [
            'key' => 'uploads/' .$fileType .'/'. date('Y/m/d') . '/' . uniqid(),
            'token' => time(),
        ];
    }
}
