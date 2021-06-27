<?php

namespace DuAdmin\Models;

use Yii;
/**
 * "{{%gen_table_column}}"表的模型类.
 *
 * @property int $id
 * @property int $tableId 表Id
 * @property string $field 字段
 * @property string $comment 注释
 * @property string $tips 提示
 * @property int $enableRequired 是否列表必填字段::0:否|1:是
 * @property int $enableList 是否列表显示字段::0:否|1:是
 * @property int $enableQuery 是否查询字段::0:否|1:是
 * @property int $enableSearch 是否搜索字段::0:否|1:是
 * @property string $sortable 排序::desc:从大到小|asc:从小到大
 * @property string $widgetType 小部件
 * @property string $dictType 字典类型
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class GenTableColumn extends \DuAdmin\Core\BaseModel
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
        return '{{%gen_table_column}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tableId', 'field', 'comment'], 'required'],
            [['tableId', 'enableRequired', 'enableList', 'enableQuery', 'enableSearch', 'sort'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['field', 'comment', 'tips', 'widgetType', 'dictType'], 'string', 'max' => 64],
            [['sortable'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app_gen_table_column', 'ID'),
            'tableId' => Yii::t('app_gen_table_column', 'Table ID'),
            'field' => Yii::t('app_gen_table_column', 'Field'),
            'comment' => Yii::t('app_gen_table_column', 'Comment'),
            'tips' => Yii::t('app_gen_table_column', 'Tips'),
            'enableRequired' => Yii::t('app_gen_table_column', 'Enable Required'),
            'enableList' => Yii::t('app_gen_table_column', 'Enable List'),
            'enableQuery' => Yii::t('app_gen_table_column', 'Enable Query'),
            'enableSearch' => Yii::t('app_gen_table_column', 'Enable Search'),
            'sortable' => Yii::t('app_gen_table_column', 'Sortable'),
            'widgetType' => Yii::t('app_gen_table_column', 'Widget Type'),
            'dictType' => Yii::t('app_gen_table_column', 'Dict Type'),
            'sort' => Yii::t('app_gen_table_column', 'Sort'),
            'createdAt' => Yii::t('app_gen_table_column', 'Created At'),
            'updatedAt' => Yii::t('app_gen_table_column', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'enableRequired' => '0:否|1:是',
            'enableList' => '0:否|1:是',
            'enableQuery' => '0:否|1:是',
            'enableSearch' => '0:否|1:是',
            'sortable' => 'desc:从大到小|asc:从小到大',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GenTableColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenTableColumnQuery(get_called_class());
    }
}
