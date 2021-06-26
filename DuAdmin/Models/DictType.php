<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%dict_type}}"表的模型类.
 *
 * @property int $id
 * @property string $dictName 字典名
 * @property string $dictType 字典类型
 * @property int $status 状态::0:不可用|1:可用
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class DictType extends \DuAdmin\Core\BaseModel
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
        return '{{%dict_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dictName', 'dictType'], 'required'],
            [['status'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['dictName', 'dictType'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_dict_type', 'ID'),
            'dictName' => Yii::t('app_dict_type', 'Dict Name'),
            'dictType' => Yii::t('app_dict_type', 'Dict Type'),
            'status' => Yii::t('app_dict_type', 'Status'),
            'createdAt' => Yii::t('app_dict_type', 'Created At'),
            'updatedAt' => Yii::t('app_dict_type', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'status' => '0:不可用|1:可用',
        ];
    }

    /**
     * {@inheritdoc}
     * @return DictTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DictTypeQuery(get_called_class());
    }
}
