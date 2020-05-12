<?php

namespace app\mmadmin\models;

/**
 * "user_ext_value"表的模型类.
 *
 * @property int $user_id 用户
 * @property string $field 属性
 * @property string $value 值
 */
class UserExtValue extends \app\mmadmin\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_ext_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'field'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['field'], 'string', 'max' => 32],
            [['user_id', 'field'], 'unique', 'targetAttribute' => ['user_id', 'field']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户',
            'field' => '属性',
            'value' => '值',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserExtValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserExtValueQuery(get_called_class());
    }
}
