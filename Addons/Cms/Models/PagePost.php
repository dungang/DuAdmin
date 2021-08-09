<?php

namespace Addons\Cms\Models;

use Yii;

/**
 * "{{%cms_page_post}}"表的模型类.
 *
 * @property int $pageId 页ID
 * @property string $language 语言
 * @property string $title 标题
 * @property string $content 内容
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class PagePost extends \DuAdmin\Core\BaseModel {
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

        return '{{%cms_page_post}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules() {

        return [
            [
                [
                    'pageId',
                    'language',
                ],
                'required'
            ],
            [
                [
                    'pageId'
                ],
                'integer'
            ],
            [
                [
                    'content'
                ],
                'string'
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
                    'language'
                ],
                'string',
                'max' => 5
            ],
            [
                [
                    'title'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'pageId',
                    'language'
                ],
                'unique',
                'targetAttribute' => [
                    'pageId',
                    'language'
                ]
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels() {

        return [
            'pageId'    => Yii::t( 'da_page_post', 'Page ID' ),
            'language'  => Yii::t( 'da_page_post', 'Language' ),
            'title'     => Yii::t( 'da_page_post', 'Title' ),
            'content'   => Yii::t( 'da_page_post', 'Content' ),
            'createdAt' => Yii::t( 'da_page_post', 'Created At' ),
            'updatedAt' => Yii::t( 'da_page_post', 'Updated At' )
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return PagePostQuery the active query used by this AR class.
     */
    public static function find() {

        return new PagePostQuery( get_called_class() );
    }

    public function getPage(){
        return $this->hasOne(Page::class,['id'=>'pageId']);
    }
}
