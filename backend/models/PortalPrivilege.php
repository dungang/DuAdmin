<?php

namespace app\backend\models;

/**
 * "{{%portal_privilege}}"表的模型类.
 *
 * @property string $role 角色
 * @property string $portals portals
 */
class PortalPrivilege extends \app\mmadmin\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portal_privilege}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['portals'], 'string'],
            [['role'], 'string', 'max' => 128],
            [['role'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role' => '角色',
            'portals' => 'portals',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PortalPrivilegeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortalPrivilegeQuery(get_called_class());
    }
}
