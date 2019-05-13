<?php

namespace app\kit\models;

/**
 * "{{%event}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $event 事件
 * @property string $level 级别
 * @property string $intro 说明
 * @property bool $is_backend 后端
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
            [['name', 'event', 'level', 'intro'], 'required'],
            [['is_backend'], 'boolean'],
            [['name', 'event', 'level'], 'string', 'max' => 64],
            [['intro'], 'string', 'max' => 255],
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
            'level' => '范围',
            'intro' => '说明',
            'is_backend' => '后端',
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
