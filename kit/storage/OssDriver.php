<?php
namespace app\kit\storage;

use OSS\OssClient;
use yii\imagine\BaseImage;

/**
 * 阿里云OSS
 *
 * @author dungang
 */
class OssDriver extends IDriver
{

    /**
     * \OSS\OSSClient
     *
     * @var \OSS\OSSClient
     */
    protected $ossClient;

    public $bucket;

    public $accessKey;

    public $accessSecret;

    public $endpoint;

    public $baseUrl;

    public function init()
    {
        $this->ossClient = new OssClient($this->accessKey, $this->accessSecret, $this->endpoint);
    }

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\storage\IDriver::getUrl()
     */
    public function getUrl($filePath)
    {
        return $this->baseUrl . '/' . parent::getUrl($filePath);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\storage\IDriver::thumbnail()
     */
    public function thumbnail($filePath, $file, $suffix, $width, $height, $mode)
    {
        $thumbnail = BaseImage::thumbnail($file->tempName, $width, $height, $mode);
        $thumbPath = $filePath . $suffix;
        $this->ossClient->putObject($this->bucket, $thumbPath, $thumbnail->__toString());
        return $thumbPath;
    }

    /**
     * (non-PHPdoc)
     *
     * @param \yii\web\UploadedFile $file
     * @see \app\kit\storage\IDriver::write()
     */
    public function write($file, $fileType)
    {
        $filePath = $this->getWriteFilePath($file, $fileType);
        $this->ossClient->uploadFile($this->bucket, $filePath, $file->tempName);
        return $filePath;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\storage\IDriver::delete()
     */
    public function delete($filename)
    {
        $this->ossClient->deleteObject($this->bucket, $filename);
        return true;
    }
}

