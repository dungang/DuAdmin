<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%pretty_url}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $express 表达式
 * @property int $weight 权重
 * @property string $route 路由
 */
class PrettyUrl extends \DuAdmin\Core\BaseModel
{
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pretty_url}}';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_pretty_url', 'ID'),
            'name' => Yii::t('app_pretty_url', 'Name'),
            'express' => Yii::t('app_pretty_url', 'Express'),
            'weight' => Yii::t('app_pretty_url', 'Weight'),
            'route' => Yii::t('app_pretty_url', 'Route'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PrettyUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrettyUrlQuery(get_called_class());
    }
}
