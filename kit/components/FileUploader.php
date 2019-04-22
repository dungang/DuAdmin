<?php
namespace app\kit\components;

use yii\base\BaseObject;
use app\kit\models\Setting;
use yii\web\UploadedFile;
use app\kit\storage\IDriver;
use yii\base\DynamicModel;

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

    public $file_path = null;

    /**
     * 文件的最大大小
     *
     * @var string
     */
    public $file_max_size = 0;

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
     * 如果是crop ,坐标X
     *
     * @var string
     */
    public $x = null;

    //如果是crop ,坐标y
    public $y = null;

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

    /**
     *
     * @var \yii\web\UploadedFile[] | \yii\web\UploadedFile
     */
    private $_file;

    private $_errors;

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
        } else if ($this->file_path) {
            return $this->file_path;
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
        $source = IDriver::THUMBNAIL_FROM_TMP;
        if ($this->x && $this->y) {
            $source = IDriver::THUMBNAIL_FROM_TARGET;
        }
        foreach ($this->thumbnails as $thumbnail) {
            self::$driver->thumbnail($source, $filePath, $file, $thumbnail['suffix'], $thumbnail['width'], $thumbnail['height'], $thumbnail['mode']);
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
            'x' => $this->x,
            'y' => $this->y,
            'mode' => $this->mode
        ];
    }

    public function fetchFile()
    {
        if ($this->model) {
            $this->_file = UploadedFile::getInstance($this->model, $this->field);
        } else {
            $this->_file = UploadedFile::getInstanceByName($this->field);
        }

        return $this;
    }

    public function fetchFiles()
    {
        if ($this->model) {
            $this->_file = UploadedFile::getInstances($this->model, $this->field);
        } else {
            $this->_file = UploadedFile::getInstancesByName($this->field);
        }
        return $this;
    }

    public function validate($rule)
    {
        $model = DynamicModel::validateData([
            $this->field => $this->_file
        ], [
            \array_unshift($rule, $this->field, 'file')
        ]);
        if ($model->hasErrors($this->field)) {
            $this->_errors = $model->getErrors($this->field);
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getFirstError()
    {
        if (count($this->_errors) > 0) {
            return $this->_errors[0];
        }
    }

    public function upload()
    {
        if (empty($this->_file)) {
            $this->fetchFile();
        }
        return $this->uploadFile($this->_file);
    }

    public function uploads()
    {
        if (empty($this->_file)) {
            $this->fetchFiles();
        }
        return $this->uploadFiles($this->_file);
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

