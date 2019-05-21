<?php

namespace app\kit\models;

/**
 * "{{%action_log}}"表的模型类.
 *
 * @property string $id
 * @property int $user_id 用户
 * @property string $action 行为
 * @property int $ip IP
 * @property int $created_at 时间
 * @property string $data 数据
 */
class ActionLog extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%action_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'action'], 'required'],
            [['user_id', 'ip', 'created_at'], 'integer'],
            [['data'], 'string'],
            [['action'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'action' => '行为',
            'ip' => 'IP',
            'created_at' => '时间',
            'data' => '数据',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ActionLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActionLogQuery(get_called_class());
    }
}