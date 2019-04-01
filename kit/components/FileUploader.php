<?php
namespace app\kit\components;

use yii\base\BaseObject;
use app\kit\models\Setting;
use yii\web\UploadedFile;

/**
 *
 * @author dungang
 */
class FileUploader extends BaseObject
{

    public $model;

    /**
     * 是否覆写原来的路径
     *
     * @var bool
     */
    public $overwrite = false;

    /**
     * 上传图片的字段
     *
     * @var string
     */
    public $field = 'pic';

    public $file_type = 'image';

    /**
     * 原图处理宽度，如果为空，不处理
     * 实际上是不保留原图，使用默认的缩略图作为原图
     *
     * @var int
     */
    public $width = null;

    /**
     * 原图处理高度，如果为空，不处理
     * 实际上是不保留原图，使用默认的缩略图作为原图
     *
     * @var int
     */
    public $height = null;

    /**
     * 原图切图模式
     * 实际上是不保留原图，使用默认的缩略图作为原图
     *
     * @var string
     */
    public $mode = 'outbound';

    /**
     * 除默认图片之外的缩略图的默认处理模式
     *
     * @var string
     */
    public $thumb_mode = 'outbound';

    /**
     * 缩略图
     * 除默认图片之外的缩略图集合,suffix默认是'_thumb.png'
     * [['width'=>100,'mode'=>'outbound','suffix'=>'_thumb.png'],
     * ['width'=>100,'height'=>100,'mode'=>'outbound','suffix'=>'_100.png'],
     * ['height'=>200,'mode'=>'outbound','suffix'=>'_200.png'],]
     *
     * @var null|array
     */
    public $thumbnails = null;

    /**
     * 存储驱动
     *
     * @var \app\kit\storage\IDriver
     */
    protected static $driver;

    public function init()
    {
        if (empty(self::$driver)) {
            /**
             * 配置对应的驱动属性
             *
             * @var array $driverConfig
             */
            $driverConfig = Setting::getSettingAssoc('storage.config');
            $driverConfig['class'] = Setting::getSettings('storage.driver', 'app\\kit\\storage\\LocalDriver');
            self::$driver = \Yii::createObject($driverConfig);
        }
    }

    /**
     * 获取覆写的路径
     *
     * @return string|NULL
     */
    protected function getOverwriteFilePath()
    {
        if ($this->overwrite) {
            if ($this->model && ! empty($this->model->{$this->field})) {
                return $this->model->{$this->field};
            }
        }
        return null;
    }

    protected function getThumbnailData()
    {
        if (is_array($this->thumbnails)) {
            $this->thumbnails = \array_map(function ($thumbnail) {
                return \array_merge([
                    'width' => null,
                    'height' => null,
                    'suffix' => '_thumb.png',
                    'mode' => $this->thumb_mode
                ], $thumbnail);
            }, $this->thumbnails);
            return true;
        }
        return false;
    }

    /**
     * 生成缩略图
     *
     * @param string $filePath
     * @param \yii\web\UploadedFile $file
     */
    protected function createThumbnails($filePath, $file)
    {
        foreach ($this->thumbnails as $thumbnail) {
            self::$driver->thumbnail($filePath, $file, $thumbnail['suffix'], $thumbnail['width'], $thumbnail['height'], $thumbnail['mode']);
        }
    }

    protected function getResize()
    {
        if (empty($this->width) && empty($this->height)) {
            return null;
        }
        return [
            'width' => $this->width,
            'height' => $this->height,
            'mode' => $this->mode
        ];
    }

    public function upload()
    {
        if ($this->model) {
            $file = UploadedFile::getInstance($this->model, $this->field);
        } else {
            $file = UploadedFile::getInstanceByName($this->field);
        }
        return $this->uploadFile($file);
    }

    public function uploads()
    {
        if ($this->model) {
            $files = UploadedFile::getInstances($this->model, $this->field);
        } else {
            $files = UploadedFile::getInstancesByName($this->field);
        }
        return $this->uploadFiles($files);
    }

    /**
     *
     * @param \yii\web\UploadedFile $file
     * @return NULL[]|string[]
     */
    public function uploadFile($file)
    {
        if ($file) {
            $filePath = self::$driver->write($file, $this->file_type, $this->getOverwriteFilePath(), $this->getResize());
            if ($this->getThumbnailData()) {
                $this->createThumbnails($filePath, $file);
            }
            return [
                'name' => $file->name,
                'url' => self::$driver->getUrl($filePath),
                'extension' => $file->extension,
                'size' => $file->size,
                'type' => $file->type
            ];
        }
        return null;
    }

    /**
     *
     * @param \yii\web\UploadedFile[] $files
     * @return NULL[][]|string[][]
     */
    public function uploadFiles($files)
    {
        $results = [];
        if ($files) {
            foreach ($files as $file) {
                $results[] = $this->uploadFile($file);
            }
        }
        return $results;
    }
}

