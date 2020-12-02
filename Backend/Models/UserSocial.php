<?php

namespace Backend\Models;

/**
 * "ma_user_social"表的模型类.
 *
 * @property int $user_id 本地用户id
 * @property string $open_id 第三方id
 * @property string $source 来源
 */
class UserSocial extends \DuAdmin\Core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ma_user_social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'open_id', 'source'], 'required'],
            [['user_id'], 'integer'],
            [['open_id'], 'string', 'max' => 64],
            [['source'], 'string', 'max' => 32],
            [['user_id', 'open_id', 'source'], 'unique', 'targetAttribute' => ['user_id', 'open_id', 'source']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '本地用户id',
            'open_id' => '第三方id',
            'source' => '来源',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserSocialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSocialQuery(get_called_class());
    }
}
