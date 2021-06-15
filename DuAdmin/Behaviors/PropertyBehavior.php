<?php
namespace DuAdmin\Behaviors;

use DuAdmin\Core\BaseModel;
use yii\base\Behavior;

/**
 * 约定一下特殊的属性
 * 系统自动处理的属性
 * 比如，
 * createdAt, 添加时间
 * updatedAt, 更新时间
 * createdBy, 添加人
 * updatedBy, 更新人
 *
 * @author dungang
 */
class PropertyBehavior extends Behavior
{

    protected $currentUser;

    public function init()
    {
        parent::init();
        if ($user = \Yii::$app->get('user', false)) {
            $this->currentUser = $user->getIdentity();
        }
    }

    public function events()
    {
        return [
            BaseModel::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseModel::EVENT_BEFORE_UPDATE => 'beforeSave'
        ];
    }

    /**
     * 在保存之前，不能在表单验证之前，
     * 因为给了初始值对导致模式搜索的时候也会自动赋值，
     * 导致查询结果不是预期的结果
     *
     * @param \yii\base\Event $event
     */
    public function beforeSave($event)
    {
        $time = date('Y-m-d H:i:s');
        /* @var $model BaseModel */
        $model = $event->sender;
        $this->setOnce('createdAt', $time, $model);
        $this->setEverytime('updatedAt', $time, $model);
        if ($this->currentUser) {
            $this->setOnce('createdBy', $this->currentUser->username,
                $model);
            $this->setEverytime('updatedBy',
                $this->currentUser->username, $model);
            ;
        }
    }

    /**
     * 只赋值一次的属性
     *
     * @param string $field
     * @param string|int $value
     * @param BaseModel $model
     */
    protected function setOnce($field, $value, $model)
    {
        if ($model->hasProperty($field) && empty($model->{$field})) {
            $model->{$field} = $value;
        }
    }

    /**
     * 每次都赋值的属性
     *
     * @param string $field
     * @param string|int $value
     * @param BaseModel $model
     */
    protected function setEverytime($field, $value, $model)
    {
        if ($model->hasProperty($field)) {
            $model->{$field} = $value;
        }
    }
}

