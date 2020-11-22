<?php
namespace app\mmadmin\behaviors;

use yii\base\Behavior;
use app\mmadmin\core\BaseModel;

/**
 * 约定一下特殊的属性
 * 系统自动处理的属性
 * 比如，
 * created_at, 添加时间
 * updated_at, 更新时间
 * creator_id, 添加人
 * updator_id, 更新人
 * creator, 创建人的名称
 * updator, 更新人的名称
 * pid, 父类
 *
 * @author dungang
 */
class PropertyBehavior extends Behavior
{

    /**
     * 当前用户
     *
     * @var \app\mmadmin\models\User
     */
    private $_user;

    public function init()
    {
        parent::init();
        $this->_user = \Yii::$app->user->getIdentity();
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
        $time = time();
        /* @var $model BaseModel */
        $model = $event->sender;
        $this->setOnce('created_at', $time, $model);
        $this->setEverytime('updated_at', $time, $model);
        $this->setOnce('pid', 0, $model);

        if ($this->_user) {
            $this->setOnce('creator_id', $this->_user->id, $model);
            $this->setEverytime('updator_id', $this->_user->id, $model);
            $this->setOnce('creator', $this->_user->nickname, $model);
            $this->setEverytime('updator', $this->_user->nickname, $model);
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

