<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%page_block_data}}"表的模型类.
 *
 * @property int $id
 * @property int $blockId 块ID
 * @property string $showTitle 显示标题
 * @property string $filter 过滤条件::如 name=duadmin&id=du 使用queryString格式
 * @property int $size 数量
 * @property string $orderBy 显示排序::如 id DESC, sort ASC
 * @property string $style 样式
 * @property int $enableCache 是否缓存::1:是|0:否
 * @property string $expiredAt 缓存过期时间
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
            [['blockId', 'size', 'enableCache', 'sort'], 'integer'],
            [['expiredAt'], 'safe'],
            [['showTitle'], 'string', 'max' => 64],
            [['filter', 'style'], 'string', 'max' => 255],
            [['orderBy'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'blockId' => Yii::t('app', 'Block ID'),
            'showTitle' => Yii::t('app', 'Show Title'),
            'filter' => Yii::t('app', 'Filter'),
            'size' => Yii::t('app', 'Size'),
            'orderBy' => Yii::t('app', 'Order By'),
            'style' => Yii::t('app', 'Style'),
            'enableCache' => Yii::t('app', 'Enable Cache'),
            'expiredAt' => Yii::t('app', 'Expired At'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'filter' => '如 name=duadmin&id=du 使用queryString格式',
            'orderBy' => '如 id DESC, sort ASC',
            'enableCache' => '1:是|0:否',
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
