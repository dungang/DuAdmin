<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%page_block}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $widget 小部件
 * @property string $sourceApp 来源App
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class PageBlock extends \DuAdmin\Core\BaseModel
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
        return '{{%page_block}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'widget', 'sourceApp'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['widget'], 'string', 'max' => 255],
            [['sourceApp'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'widget' => Yii::t('app', 'Widget'),
            'sourceApp' => Yii::t('app', 'Source App'),
            'createdAt' => Yii::t('da', 'Created At'),
            'updatedAt' => Yii::t('da', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageBlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageBlockQuery(get_called_class());
    }
}
