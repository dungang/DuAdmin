<?php

namespace Backend\Models;

/**
 * "{{%portal}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $code 代码
 * @property string $source 来源
 * @property bool $is_static 是统计
 * @property bool $unlimited 无限制
 */
class Portal extends \DuAdmin\Core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%portal}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_static', 'unlimited'], 'boolean'],
            [['name', 'code'], 'string', 'max' => 128],
            [['source'], 'string', 'max' => 32],
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
            'code' => '代码',
            'source' => '来源',
            'is_static' => '是统计',
            'unlimited' => '无限制',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PortalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortalQuery(get_called_class());
    }
}
