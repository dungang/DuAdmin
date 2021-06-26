<?php

namespace Addons\Cms\Models;

use Yii;

/**
 * {{%cms_flash}}表的模型类.
 *
 * @property int $id
 * @property string $language 语言
 * @property string $name 名称
 * @property string $pic 图片
 * @property string $bgColor 背景颜色
 * @property string $url 地址
 * @property int $sort 排序
 * @property int $createdAt 添加时间
 * @property int $updatedAt 更新时间
 */
class Flash extends \DuAdmin\Core\BaseModel {

  /**
   *
   * {@inheritdoc}
   */
  public static function tableName() {

    return '{{%cms_flash}}';

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'name'
            ],
            'required'
        ],
        [
            [
                'sort'
            ],
            'integer'
        ],
        [
            [
                'name'
            ],
            'string',
            'max' => 64
        ],
        [
            [
                'url',
                'pic'
            ],
            'string',
            'max' => 128
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
                'bgColor'
            ],
            'string',
            'max' => 255
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'da_flash', 'ID' ),
        'name' => Yii::t( 'da_flash', 'Name' ),
        'pic' => Yii::t( 'da_flash', 'Pic' ),
        'url' => Yii::t( 'da_flash', 'Url' ),
        'bgColor' => Yii::t( 'da_flash', 'Bg Color' ),
        'sort' => Yii::t( 'da_flash', 'Sort' ),
        'createdAt' => Yii::t( 'da_flash', 'Created At' ),
        'updatedAt' => Yii::t( 'da_flash', 'Updated At' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   * @return FlashQuery the active query used by this AR class.
   */
  public static function find() {

    return new FlashQuery( get_called_class() );

  }
}
