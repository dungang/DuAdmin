<?php

namespace app\kit\models;

/**
 * "sys_rewrite"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $express 表达式
 * @property int $weight 权重
 * @property string $route 路由
 * @property string $category 归类
 */
class Rewrite extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_rewrite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'express', 'weight', 'route'], 'required'],
            [['weight'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['express', 'route'], 'string', 'max' => 128],
            [['category'], 'string', 'max' => 32],
            [['express'], 'unique'],
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
            'express' => '表达式',
            'weight' => '权重',
            'route' => '路由',
            'category' => '归类',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RewriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RewriteQuery(get_called_class());
    }
}
