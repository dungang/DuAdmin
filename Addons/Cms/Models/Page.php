<?php

namespace Addons\Cms\Models;

use Yii;

/**
 * "{{%page}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父页
 * @property string $slug Slug
 * @property string $title 标题
 * @property string $template 模板
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class Page extends \DuAdmin\Core\BaseModel {

  // /**
  // * 对象json序列化的时候设置不显示的字段
  // *
  // * @var array
  // */
  // public $jsonHideFields = [];
  /**
   *
   * {@inheritdoc}
   */
  public static function tableName() {

    return '{{%cms_page}}';

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'pid',
                'sort'
            ],
            'integer'
        ],
        [
            [
                'createdAt',
                'updatedAt'
            ],
            'safe'
        ],
        [
            [
                'slug',
                'title',
                'template'
            ],
            'string',
            'max' => 128
        ],
        [
            [
                'slug'
            ],
            'unique'
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'da_page', 'ID' ),
        'pid' => Yii::t( 'da_page', 'Pid' ),
        'slug' => Yii::t( 'da_page', 'Slug' ),
        'title' => Yii::t( 'da_page', 'Title' ),
        'template' => Yii::t( 'da_page', 'Template' ),
        'sort' => Yii::t( 'da_page', 'Sort' ),
        'createdAt' => Yii::t( 'da_page', 'Created At' ),
        'updatedAt' => Yii::t( 'da_page', 'Updated At' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   * @return PageQuery the active query used by this AR class.
   */
  public static function find() {

    return new PageQuery( get_called_class() );

  }

  public function getLanguages() {

    return $this->hasMany( PagePost::class, [
        'pageId' => 'id'
    ] )->select( [
        'pageId',
        'language'
    ] );

  }

  public function getPost() {

    $language = \Yii::$app->request->get( 'language', \Yii::$app->language );
    return $this->hasOne( PagePost::class, [
        'pageId' => 'id'
    ] )->where( [
        'language' => $language
    ] );

  }
}
