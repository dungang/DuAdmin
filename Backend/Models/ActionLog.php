<?php

namespace Backend\Models;

use Yii;
/**
 * "{{%action_log}}"表的模型类.
 *
 * @property int $id
 * @property int $userId 用户
 * @property string $action 行为
 * @property int $ip IP
 * @property string $method 方法
 * @property string $sourceType 来源::Backend:后台|Frontend:前台|Api:API
 * @property string $createdAt 时间
 * @property string $data 数据
 */
class ActionLog extends \DuAdmin\Core\BaseModel
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
            [['userId'], 'required'],
            [['userId', 'ip'], 'integer'],
            [['createdAt'], 'safe'],
            [['data'], 'string'],
            [['action'], 'string', 'max' => 128],
            [['method'], 'string', 'max' => 8],
            [['sourceType'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'userId' => Yii::t('backend', 'User ID'),
            'action' => Yii::t('backend', 'Action'),
            'ip' => Yii::t('backend', 'Ip'),
            'method' => Yii::t('backend', 'Method'),
            'sourceType' => Yii::t('backend', 'Source Type'),
            'createdAt' => Yii::t('da', 'Created At'),
            'data' => Yii::t('backend', 'Data'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'sourceType' => 'Backend:后台|Frontend:前台|Api:API',
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
