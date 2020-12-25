<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%page_block}}"表的模型类.
 *
 * @property int $id
 * @property string $title 标题
 * @property string $showTitle 显示标题
 * @property int $size 数量
 * @property string $background 背景
 * @property int $isActive 是否激活::1:是|0:否
 * @property string $widget 小部件
 * @property string $sourceApp 来源App
 * @property int $sort 排序
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
            [['title', 'widget', 'sourceApp'], 'required'],
            [['size', 'isActive', 'sort'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title', 'showTitle'], 'string', 'max' => 64],
            [['background', 'widget'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'showTitle' => Yii::t('app', 'Show Title'),
            'size' => Yii::t('app', 'Size'),
            'background' => Yii::t('app', 'Background'),
            'isActive' => Yii::t('app', 'Is Active'),
            'widget' => Yii::t('app', 'Widget'),
            'sourceApp' => Yii::t('app', 'Source App'),
            'sort' => Yii::t('app', 'Sort'),
            'createdAt' => Yii::t('da', 'Created At'),
            'updatedAt' => Yii::t('da', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'isActive' => '1:是|0:否',
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
