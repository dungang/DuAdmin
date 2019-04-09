<?php
namespace app\kit\storage;

use OSS\OssClient;
use yii\imagine\BaseImage;
use yii\helpers\FileHelper;

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

    /**
     * oss的文件上传的地址，
     * 注意区分内网地址，和外网地址
     * 最好根据自己的服务器地址来选择
     *
     * @var string
     */
    public $endpoint;

    /**
     * web访问的baseurl
     *
     * @var string
     */
    public $baseUrl;
    
    protected $webroot;

    public function init()
    {
        $this->ossClient = new OssClient($this->accessKey, $this->accessSecret, $this->endpoint);
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
     * @see \app\kit\storage\IDriver::getUrl()
     */
    public function getUrl($filePath)
    {
        return $this->baseUrl . '/' . parent::getUrl($filePath);
    }

    /**
     * (non-PHPdoc)
     *
     * @param \yii\web\UploadedFile $file
     * @see \app\kit\storage\IDriver::write()
     */
    public function write($file, $fileType, $filePath = NULL, $resize = NULL)
    {
        if ($filePath == NULL) {
            $filePath = $this->getWriteFilePath($file, $fileType);
        } else {
            $filePath = $this->parseFilePath($filePath);
        }
        if ($resize) {
            if ($resize['x'] === NULL || $resize['y'] === NULL) {
                $this->thumbnail(self::THUMBNAIL_FROM_TMP, $filePath, $file, '', $resize['width'], $resize['height'], $resize['mode']);
            } else {
                $this->crop($filePath, $file, '', $resize['width'], $resize['height'], $resize['x'], $resize['y']);
            }
        } else {
            $targetFile = $this->webroot . '/' . $filePath;
            $file->saveAs($targetFile, false);
            $this->ossClient->uploadFile($this->bucket, $filePath, $file->tempName);
        }
        return $filePath;
    }

    /**
     * 如果匹配不上，则返回NULL
     *
     * @param string $ossUrl
     * @return string|NULL
     */
    protected function parseFilePath($ossUrl)
    {
        return \parse_url($ossUrl, PHP_URL_PATH);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\storage\IDriver::thumbnail()
     */
    public function thumbnail($thumbnail_source, $filePath, $file, $suffix, $width, $height, $mode)
    {
        $targetFile = $this->webroot . '/' . $filePath;
        if ($thumbnail_source === self::THUMBNAIL_FROM_TMP) {
            $thumbnail = BaseImage::thumbnail($file->tempName, $width, $height, $mode);
        } else {
            $thumbnail = BaseImage::thumbnail($targetFile, $width, $height, $mode);
        }
        $thumbPath = $filePath . $suffix;
        $thumbnail->save($thumbPath, $this->getImageQualities());
        $this->ossClient->putObject($this->bucket, $thumbPath, $thumbnail->get('png', $this->getImageQualities()));
        return $thumbPath;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\storage\IDriver::crop()
     */
    public function crop($filePath, $file, $suffix, $width, $height, $x, $y)
    {
        $crop = BaseImage::crop($file->tempName, $width, $height, [
            $x,
            $y
        ]);
        $cropPath = $filePath . $suffix;
        $crop->save($cropPath, $this->getImageQualities());
        $this->ossClient->putObject($this->bucket, $cropPath, $crop->get('png', $this->getImageQualities()));
        return $cropPath;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\storage\IDriver::delete()
     */
    public function delete($filename)
    {
        if ($key = $this->parseFilePath($filename)) {
            $this->ossClient->deleteObject($this->bucket, $key);
        }
        return true;
    }
}

