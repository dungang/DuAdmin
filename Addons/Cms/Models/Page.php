<?php

namespace Addons\Cms\Models;

use Yii;
/**
 * "{{%cms_page}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父页
 * @property string $slug 页面路径
 * @property string $title 标题
 * @property string $keywords 关键字
 * @property string $description 简介
 * @property int $isLiveEdit 在线编辑
 * @property string $showMode 在线编辑
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class Page extends \DuAdmin\Core\BaseModel
{
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    // /**
    //  * 存储的数据是json的字段
    //  *
    //  * @var array
    //  */
    // public $jsonFields = [];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'isLiveEdit', 'sort'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['slug', 'title', 'keywords'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            [['showMode'], 'string', 'max' => 32],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('da_cms_page', 'ID'),
            'pid' => Yii::t('da_cms_page', 'Pid'),
            'slug' => Yii::t('da_cms_page', 'Slug'),
            'title' => Yii::t('da_cms_page', 'Title'),
            'keywords' => Yii::t('da_cms_page', 'Keywords'),
            'description' => Yii::t('da_cms_page', 'Description'),
            'isLiveEdit' => Yii::t('da_cms_page', 'Is Live Edit'),
            'showMode' => Yii::t('da_cms_page', 'Show Mode'),
            'sort' => Yii::t('da_cms_page', 'Sort'),
            'createdAt' => Yii::t('da_cms_page', 'Created At'),
            'updatedAt' => Yii::t('da_cms_page', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    public function getLanguages()
    {
        return $this->hasMany(PagePost::class, [
            'pageId' => 'id'
        ])->select([
            'pageId',
            'language'
        ]);
    }

    public function getPost()
    {
        $language = \Yii::$app->request->get('language', \Yii::$app->language);
        return $this->hasOne(PagePost::class, [
            'pageId' => 'id'
        ])->where([
            'language' => $language
        ]);
    }
}
