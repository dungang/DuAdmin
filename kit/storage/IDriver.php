<?php
namespace app\kit\storage;

use yii\base\BaseObject;

/**
 * 文件存储驱动接口类
 *
 * @author dungang
 */
abstract class IDriver extends BaseObject
{

    /**
     * from 0 to 100
     *
     * @var int
     */
    public $quality_jpeg = 100;

    /**
     * form 0 to 9
     *
     * @var int
     */
    public $quality_png = 9;

    public function getImageQualities()
    {
        return [
            'jpeg_quality' => $this->quality_jpeg,
            'png_compression_level' => $this->quality_png
        ];
    }

    /**
     * 获取url地址
     *
     * @param string $filePath
     * @return string
     */
    public function getUrl($filePath)
    {
        return $filePath;
    }

    /**
     * 初始化保存文件的相对路径
     *
     * @param string $fileType
     *            文件类型，只是在路径中添加一个目录方便程序业务规划文件路径
     * @return string
     */
    public function initWritePath($fileType)
    {
        return 'uploads/' . $fileType . '/' . Date('Y/m-d/');
    }

    /**
     * 相对路径
     * 如果是本地则是相对webroot的路径
     * 如果是Oss类则是objectKey
     *
     * @param \yii\web\UploadedFile; $file
     * @return string
     */
    public function getWriteFilePath($file, $fileType)
    {
        return $this->initWritePath($fileType) . uniqid($fileType, true) . '.' . $file->extension;
    }

    /**
     * 写文件
     *
     * @param \yii\web\UploadedFile $file
     * @param string $fileType
     * @param string|null $filePath
     *            如果不为空则保存文件在该路径
     * @param
     *            array|null 不保留原图重新定义大小（图片文件生效）
     * @return string 返回 文件存储的相对路径
     */
    public abstract function write($file, $fileType, $filePath = null, $resize = null);

    /**
     * 缩略图
     * 参考imagine包
     *
     * @param string $filePath
     *            原始文件存储的相对路径
     * @param \yii\web\UploadedFile $file
     *            相对路径
     * @param string $suffix
     *            文件后缀
     * @param string $width
     * @param string $height
     * @param string $mode
     */
    public abstract function thumbnail($filePath, $file, $suffix, $width, $height, $mode);

    /**
     * 裁剪图片
     * 参考imagine包
     *
     * @param string $filePath
     *            原始文件存储的相对路径
     * @param \yii\web\UploadedFile $file
     *            相对路径
     * @param string $suffix
     *            文件后缀
     * @param string $width
     * @param string $height
     * @param int $x
     * @param int $y
     */
    public abstract function crop($filePath, $file, $suffix, $width, $height, $x, $y);

    /**
     * 删除文件
     *
     * @param string $filename
     */
    public abstract function delete($filename);
}

