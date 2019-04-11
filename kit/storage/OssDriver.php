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

    /**
     * 内部交换变量
     *
     * @var mixed
     */
    private $img;

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
                $this->img = $this->thumbnail(self::THUMBNAIL_FROM_TMP, $filePath, $file, '', $resize['width'], $resize['height'], $resize['mode']);
            } else {
                $this->img = $this->crop($filePath, $file, '', $resize['width'], $resize['height'], $resize['x'], $resize['y']);
            }
        } else {
            $this->img = $file->tempName;
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
        if ($thumbnail_source === self::THUMBNAIL_FROM_TMP) {
            $thumbnail = BaseImage::thumbnail($file->tempName, $width, $height, $mode);
        } else {
            $thumbnail = BaseImage::thumbnail($this->img, $width, $height, $mode);
        }
        $thumbPath = $filePath . $suffix;
        $this->ossClient->putObject($this->bucket, $thumbPath, $thumbnail->get('png', $this->getImageQualities()));
        return $thumbnail;
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
        $this->ossClient->putObject($this->bucket, $cropPath, $crop->get('png', $this->getImageQualities()));
        return $crop;
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

