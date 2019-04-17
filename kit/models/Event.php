<?php

namespace app\kit\models;

/**
 * "event"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $event 事件
 * @property string $level 级别
 */
class Event extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'event', 'level'], 'required'],
            [['name', 'event', 'level'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'event' => '事件',
            'level' => '级别',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }
}
