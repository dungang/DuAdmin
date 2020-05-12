<?php

namespace app\backend\models;

/**
 * "{{%auth_group}}"表的模型类.
 *
 * @property string $name 组
 * @property string $title 标题
 * @property int $type 类型
 * @property bool $is_backend 是后台
 */
class AuthGroup extends \app\mmadmin\core\BaseModel
{
    /** 
     * 角色 
     * 
     * @var integer 
     */
    const TYPE_ROLE = 1;

    /** 
     * 权限 
     * 
     * @var integer 
     */
    const TYPE_PERMISSION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['type'], 'integer'],
            [['is_backend'], 'boolean'],
            [['name', 'title'], 'string', 'max' => 128],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => '组',
            'title' => '标题',
            'type' => '类型',
            'is_backend' => '后端',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AuthGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthGroupQuery(get_called_class());
    }
}
