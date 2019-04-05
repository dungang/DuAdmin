<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\InvalidArgumentException;

/**
 *
 * @author dungang
 */
class CascadeDelete extends Behavior
{

    /**
     * 联级删除的对象模型类
     *
     * @var string
     */
    public $targetActiveModel;

    /**
     * 删除的条件字段映射
     * [
     * 'product_id'=>'id'
     * ]
     *
     * @var array
     */
    public $fieldsMap;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterDelete($event)
    {
        if (\class_exists($this->targetActiveModel)) {
            $model = $event->sender;
            $cond = [];
            foreach ($this->fieldsMap as $field => $val) {
                if (! $model->hasProperty($val)) {
                    throw new InvalidArgumentException('条件字段不存在');
                }
                $cond[$field] = $model->{$val};
            }
            
            \call_user_func([
                $this->targetActiveModel,
                'deleteAll'
            ], $cond);
        }
    }
}

