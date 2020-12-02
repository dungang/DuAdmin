<?php

namespace Backend\Models;

/**
 * "{{%portal_place}}"表的模型类.
 *
 * @property int $user_id 用户
 * @property string $portals
 */
class PortalPlace extends \DuAdmin\Core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portal_place}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['portals'], 'string'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户',
            'portals' => 'Portals',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PortalPlaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortalPlaceQuery(get_called_class());
    }
}
