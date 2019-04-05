<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\kit\components\FileUploader;
use yii\helpers\ArrayHelper;

/**
 * 图片上传行为
 *
 * @author dungang
 */
class UploadedFileBehavior extends Behavior
{

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
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate'
        ];
    }

    public function beforeValidate($event)
    {
        if($this->initFieldsCallback && \is_callable($this->initFieldsCallback)){
            \call_user_func($this->initFieldsCallback,$this);
        }
        foreach (array_keys($this->fields) as $field) {
            /* @var $model ActiveRecord  */
            $model = $this->owner;
            $file = UploadedFile::getInstance($model, $field);
            if ($file) {
                $model->{$field} = $file;
            } else if($model->hasMethod('getOldAttribute')) {
                $model->{$field} = $model->getOldAttribute($field);
            }
        }
    }

    public function afterValidate($event)
    {
        /* @var $model ActiveRecord  */
        $model = $this->owner;
        foreach ($this->fields as $field => $config) {
            if($model->hasProperty($field)){
                if ($model->{$field} instanceof UploadedFile) {
                    $fileUploader = $this->getFileUploader($model, $config);
                    if ($file = $fileUploader->uploadFile($model->{$field})) {
                        $model->{$field} = $file['url'];
                    }
                }
            }
        }
    }

    protected function getFileUploader($model, $config)
    {
        return new FileUploader(ArrayHelper::merge([
            'model' => $model,
            'file_path'=>null,
            'file_type' => 'image',
            'thumbnails' => null,
            'width' => null,
            'height' => null,
            'mode' => 'outbound'
        ], $config));
    }
}

