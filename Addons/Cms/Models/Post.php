<?php

namespace Addons\Cms\Models;

use Yii;

/**
 * "{{%post}}"表的模型类.
 *
 * @property int $id
 * @property int $userId 编辑ID
 * @property int $cateId 分类ID
 * @property string $slug Slug
 * @property string $title 标题
 * @property string $cover 首图
 * @property string $keywords 关键字
 * @property string $description 简介
 * @property string $content 内容
 * @property int $isPublished 发布状态
 * @property int $viewTimes 阅读次数
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 * 
 * @property Category $category
 * @property Backend\Models\Admin $admin
 */
class Post extends \DuAdmin\Core\BaseModel
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
        return '{{%post}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'cateId', 'isPublished', 'viewTimes'], 'integer'],
            [['content'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['slug', 'title', 'cover', 'keywords'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('da_post', 'ID'),
            'userId' => Yii::t('da_post', 'User ID'),
            'cateId' => Yii::t('da_post', 'Cate ID'),
            'slug' => Yii::t('da_post', 'Slug'),
            'title' => Yii::t('da_post', 'Title'),
            'cover' => Yii::t('da_post', 'Cover'),
            'keywords' => Yii::t('da_post', 'Keywords'),
            'description' => Yii::t('da_post', 'Description'),
            'content' => Yii::t('da_post', 'Content'),
            'isPublished' => Yii::t('da_post', 'Is Published'),
            'viewTimes' => Yii::t('da_post', 'View Times'),
            'createdAt' => Yii::t('da_post', 'Created At'),
            'updatedAt' => Yii::t('da_post', 'Updated At'),
        ];
    }
    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'cateId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne('Backend\Models\Admin', ['id' => 'userId']);
    }
}
