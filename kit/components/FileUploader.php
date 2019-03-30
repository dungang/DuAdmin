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
     * 是否生成缩略图
     *
     * @var bool
     */
    public $thumbnail = false;

    /**
     * 缩略图宽
     *
     * @var int
     */
    public $thumb_width = null;

    /**
     * 缩略图高
     *
     * @var int
     */
    public $thumb_height = null;

    /**
     * 缩略图模式
     *
     * @var string
     */
    public $thumb_mode = 'outbound';

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
            $filePath = self::$driver->write($file, $this->file_type, $this->getOverwriteFilePath());
            if ($this->thumbnail) {
                self::$driver->thumbnail($filePath, $file, '_thumb.png', $this->thumb_width, $this->thumb_height, $this->thumb_mode);
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

