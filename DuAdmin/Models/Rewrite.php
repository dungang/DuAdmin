<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "rewrite"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $express 表达式
 * @property int $weight 权重
 * @property string $route 路由
 * @property string $category 归类
 */
class Rewrite extends \DuAdmin\Core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rewrite}}';
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
            'id' =>  Yii::t('app_rewrite', 'ID'),
            'name' => Yii::t('app_rewrite', 'Name'),
            'express' => Yii::t('app_rewrite', 'Express'),
            'weight' => Yii::t('app_rewrite', 'Weight'),
            'route' => Yii::t('app_rewrite', 'Route'),
            'category' => Yii::t('app_rewrite', 'Category')
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
