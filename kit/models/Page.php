<?php

namespace app\kit\models;

use app\kit\helpers\KitHelper;

/**
 * "sys_page"表的模型类.
 *
 * @property int $id
 * @property string $slug Slug
 * @property int $pid 父页
 * @property string $title 标题
 * @property string $content 内容
 * @property int $sort 排序
 */
class Page extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['pid', 'sort'], 'integer'],
            [['content'], 'string'],
            [['slug', 'title'], 'string', 'max' => 128],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'pid' => '父页',
            'title' => '标题',
            'content' => '内容',
            'sort' => '排序',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'slug' => '英文或者拼音单词之间用中横线连接，比如：about-us',
            'pid' => '父页编码，可以不填写,则表示一级页面',
        ];
    }
    
    public static function getMapWidthDep()
    {
        return KitHelper::dbQueryAsMapLikeTree(self::tableName(), 'title');
    }
    
    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
