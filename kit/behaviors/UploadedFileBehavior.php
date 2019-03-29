<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\kit\helpers\KitHelper;
use yii\web\UploadedFile;

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
     * @var string
     */
    public $field = 'pic';

    public $fileType = 'image';

    public $thumbnail = false;

    public $thumb_width = null;

    public $thumb_height = null;
    
    public $thumb_mode = 'outbound';

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
        /* @var $model ActiveRecord  */
        $model = $this->owner;
        if ($file = UploadedFile::getInstance($model, $this->field)) {
            $model->{$this->field} = $file;
        } else {
            $model->{$this->field} = $model->getOldAttribute($this->field);
        }
    }

    public function afterValidate($event)
    {
        /* @var $model ActiveRecord  */
        $model = $this->owner;
        if ($model->{$this->field} instanceof UploadedFile) {
            if ($file = KitHelper::saveModelAttachment($model->{$this->field}, $this->fileType, $this->thumbnail, $this->thumb_width, $this->thumb_height,$this->thumb_mode)) {
                $model->{$this->field} = $file['url'];
            }
        }
    }
}

