<?php

namespace Addons\Cms\Models;

use Yii;
/**
 * "{{%cms_page_block}}"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $type 类型::element:静态元素|layout:布局
 * @property string $namespace 命名空间
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
        return '{{%cms_page_block}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['type'], 'string', 'max' => 16],
            [['namespace'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('da_cms_page_block', 'ID'),
            'name' => Yii::t('da_cms_page_block', 'Name'),
            'type' => Yii::t('da_cms_page_block', 'Type'),
            'namespace' => Yii::t('da_cms_page_block', 'Namespace'),
            'sort' => Yii::t('da_cms_page_block', 'Sort'),
            'createdAt' => Yii::t('da_cms_page_block', 'Created At'),
            'updatedAt' => Yii::t('da_cms_page_block', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'type' => 'element:静态元素|layout:布局',
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
