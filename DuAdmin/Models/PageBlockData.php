<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%page_block_data}}"表的模型类.
 *
 * @property int $id
 * @property int $blockId 块ID
 * @property string $title 标题
 * @property string $intro 说明
 * @property string $url 地址
 * @property int $isOuterUrl 是外部地址::1:是|0:否
 * @property string $urlText 地址标题
 * @property string $filter 过滤条件::如 name=duadmin&id=du 使用queryString格式
 * @property int $size 数量
 * @property string $orderBy 显示排序::如 id DESC, sort ASC
 * @property string $style 样式
 * @property string $options 元素选项::yii框架类似选项使用queryString设置
 * @property int $enableCache 是否缓存::1:是|0:否
 * @property string $expiredAt 缓存过期时间::0和空表示永久缓存
 * @property int $sort 排序
 */
class PageBlockData extends \DuAdmin\Core\BaseModel
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
        return '{{%page_block_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blockId'], 'required'],
            [['blockId', 'isOuterUrl', 'size', 'enableCache', 'sort'], 'integer'],
            [['intro'], 'string'],
            [['expiredAt'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['url', 'urlText'], 'string', 'max' => 128],
            [['filter', 'style', 'options'], 'string', 'max' => 255],
            [['orderBy'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_page_block_data', 'ID'),
            'blockId' => Yii::t('app_page_block_data', 'Block ID'),
            'title' => Yii::t('app_page_block_data', 'Title'),
            'intro' => Yii::t('app_page_block_data', 'Intro'),
            'url' => Yii::t('app_page_block_data', 'Url'),
            'isOuterUrl' => Yii::t('app_page_block_data', 'Is Outer Url'),
            'urlText' => Yii::t('app_page_block_data', 'Url Text'),
            'filter' => Yii::t('app_page_block_data', 'Filter'),
            'size' => Yii::t('app_page_block_data', 'Size'),
            'orderBy' => Yii::t('app_page_block_data', 'Order By'),
            'style' => Yii::t('app_page_block_data', 'Style'),
            'options' => Yii::t('app_page_block_data', 'Options'),
            'enableCache' => Yii::t('app_page_block_data', 'Enable Cache'),
            'expiredAt' => Yii::t('app_page_block_data', 'Expired At'),
            'sort' => Yii::t('app_page_block_data', 'Sort'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'isOuterUrl' => '1:是|0:否',
            'filter' => '如 name=duadmin&id=du 使用queryString格式',
            'orderBy' => '如 id DESC, sort ASC',
            'options' => 'yii框架类似选项使用queryString设置',
            'enableCache' => '1:是|0:否',
            'expiredAt' => '0和空表示永久缓存',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageBlockDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageBlockDataQuery(get_called_class());
    }
    
    public function getBlock(){
        return $this->hasOne(PageBlock::class, ['id'=>'blockId']);
    }
}
