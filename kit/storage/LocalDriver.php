<?php
namespace app\kit\storage;

use yii\helpers\FileHelper;
use yii\imagine\BaseImage;

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
     * @see \app\kit\storage\IDriver::initWritePath()
     */
    public function initWritePath($fileType)
    {
        $dir = parent::initWritePath($fileType);
        $path = $this->webroot . '/' . $dir;
        if (! is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        return $dir;
    }

    /**
     *
     * {@inheritdoc}
     * @param \yii\web\UploadedFile $file
     * @see \app\kit\storage\IDriver::write()
     */
    public function write($file, $fileType)
    {
        $filePath = $this->getWriteFilePath($file, $fileType);
        $targetFile = $this->webroot . '/' . $filePath;
        //不立刻删除临时文件，方便后面的程序还可以使用临时文件
        $file->saveAs($targetFile, false);
        return $filePath;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\storage\IDriver::thumbnail()
     */
    public function thumbnail($filePath, $file, $suffix, $width, $height, $mode)
    {
        $targetFile = $this->webroot . '/' . $filePath;
        $thumbnail = BaseImage::thumbnail($file->tempName, $width, $height, $mode);
        $thumbPath = $targetFile . $suffix;
        $thumbnail->save($thumbPath);
        return $thumbPath;
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\storage\IDriver::delete()
     */
    public function delete($filename)
    {
        // TODO Auto-generated method stub
    }
}

