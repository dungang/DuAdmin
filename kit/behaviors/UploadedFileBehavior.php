<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\kit\components\FileUploader;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * 图片上传行为
 *
 * @author dungang
 */
class UploadedFileBehavior extends Behavior
{


    /**
     * 是否在模型数据添加成功后处理图片
     *
     * @var boolean
     */
    public $after_create = false;

    /**
     * 是否开启图片裁剪
     *
     * @var boolean
     */
    public $enable_crop = false;

    /**
     * 上传图片的字段
     *
     * @var string|array
     */
    public $fields = [
        'pic' => [
            'file_type' => 'image'
        ]
    ];

    /**
     * 动态初始化上传文件的参数
     * @var string
     */
    public $initFieldsCallback;

    /**
     * 调整默认的绑定事件的逻辑，只有是POST请求的时候才绑定
     * 因为上传图片肯定是POST请求,
     * 如果不添加限制，导致普通的请求也会绑定事件，
     * 比如查询搜索，没有必要执行相关代码，提高性能
     *
     * {@inheritdoc}
     * @see \yii\base\Behavior::attach()
     */
    public function attach($owner)
    {
        if (\Yii::$app->request->isPost) {
            parent::attach($owner);
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'whenNewRecordSaveAfterCreated',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate'
        ];
    }

    public function whenNewRecordSaveAfterCreated($event)
    {
        if ($this->onlyIsNewRecordSaveFileAfterCreated()) {
            $this->initUploader();
            $this->saveFile($event);
            $this->owner->save(false);
        }
    }

    public function beforeValidate($event)
    {
        if ($this->canSaveFileBeforeSave()) {
            $this->initUploader();
            foreach (array_keys($this->fields) as $field) {

                /* @var $model ActiveRecord  */
                $model = $this->owner;
                if ($model->hasProperty($field)) {
                    $file = UploadedFile::getInstance($model, $field);
                    if ($file) {
                        $model->{$field} = $file;
                    } else if ($model->hasMethod('getOldAttribute')) {
                        $model->{$field} = $model->getOldAttribute($field);
                    }
                }
            }
        }
    }

    public function afterValidate($event)
    {
        if ($this->canSaveFileBeforeSave()) {
            $this->saveFile($event);
        }
    }

    protected function initCrop()
    {
        if($this->enable_crop){

            foreach ($this->fields as $field => $config) {
                $crop = Json::decode(\Yii::$app->request->post($field . '_crop'));
                if ($crop) {
                    $config['width'] = $crop['w'];
                    $config['height'] = $crop['h'];
                    $config['x'] = $crop['x'];
                    $config['y'] = $crop['y'];
                }
                $this->fields = [
                    $field => $config
                ];
            }
        }
    }

    protected function onlyIsNewRecordSaveFileAfterCreated()
    {
        return $this->after_create === true && $this->owner->isNewRecord;
    }

    protected function canSaveFileBeforeSave()
    {
        return $this->after_create === false || ($this->after_create === true && !$this->owner->isNewRecord);
    }

    protected function saveFile($event)
    {
        /* @var $model ActiveRecord  */
        $model = $this->owner;
        foreach ($this->fields as $field => $config) {
            if ($model->hasProperty($field)) {
                if ($model->{$field} instanceof UploadedFile) {
                    $fileUploader = $this->getFileUploader($model, $config);
                    if ($file = $fileUploader->uploadFile($model->{$field})) {
                        $model->{$field} = $file['url'];
                    }
                }
            }
        }
    }

    protected function initUploader()
    {
        $this->initCrop();
        if ($this->initFieldsCallback && \is_callable($this->initFieldsCallback)) {
            \call_user_func($this->initFieldsCallback, $this);
        }
    }

    protected function getFileUploader($model, $config)
    {
        return new FileUploader(ArrayHelper::merge([
            'model' => $model,
            'file_path' => null,
            'file_type' => 'image',
            'thumbnails' => null,
            'width' => null,
            'height' => null,
            'mode' => 'outbound'
        ], $config));
    }
}
