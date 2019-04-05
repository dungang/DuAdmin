<?php

namespace app\kit\models;

/**
 * "sys_user_ext_property"表的模型类.
 *
 * @property int $id
 * @property string $field 字段
 * @property string $name 名称
 * @property string $data_type 数据类型
 * @property int $data_length 长度
 * @property string $hint 备注
 * @property bool $is_required 必填
 * @property string $input_type 输入框
 * @property string $input_value 输入值
 * @property int $sort 排序
 */
class UserExtProperty extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_user_ext_property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_length', 'sort'], 'integer'],
            [['is_required'], 'boolean'],
            [['input_value'], 'string'],
            [['field', 'name', 'data_type', 'input_type'], 'string', 'max' => 32],
            [['hint'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field' => '字段',
            'name' => '名称',
            'data_type' => '数据类型',
            'data_length' => '长度',
            'hint' => '备注',
            'is_required' => '必填',
            'input_type' => '输入框',
            'input_value' => '输入值',
            'sort' => '排序',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserExtPropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserExtPropertyQuery(get_called_class());
    }
}
