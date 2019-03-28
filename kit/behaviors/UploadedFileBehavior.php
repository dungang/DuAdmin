<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\kit\helpers\KitHelper;
use yii\web\UploadedFile;

/**
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
        //\var_dump($model->{$this->field});die;
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
            if ($file = KitHelper::saveModelAttachment($model->{$this->field}, $this->fileType, $this->thumbnail, $this->thumb_width, $this->thumb_height)) {
                $model->{$this->field} = $file['url'];
            }
        }
    }
}

