<?php

namespace DuAdmin\Models;

use Yii;

/**
 * "{{%dict_data}}"表的模型类.
 *
 * @property int $id
 * @property string $dictLabel 字典标签
 * @property string $dictValue 字典键值
 * @property string $dictType 字典类型
 * @property string $listCss 显示样式
 * @property int $isDefault 是否默认值::0:否|1:是
 * @property int $sort 排序
 * @property int $status 状态::0:不可用|1:可用
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 */
class DictData extends \DuAdmin\Core\BaseModel {

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

    return '{{%dict_data}}';

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'dictLabel',
                'dictValue',
                'dictType'
            ],
            'required'
        ],
        [
            [
                'isDefault',
                'sort',
                'status'
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
                'dictLabel',
                'dictValue',
                'dictType',
                'listCss'
            ],
            'string',
            'max' => 64
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'app_dict_data', 'ID' ),
        'dictLabel' => Yii::t( 'app_dict_data', 'Dict Label' ),
        'dictValue' => Yii::t( 'app_dict_data', 'Dict Value' ),
        'dictType' => Yii::t( 'app_dict_data', 'Dict Type' ),
        'listCss' => Yii::t( 'app_dict_data', 'List Css' ),
        'isDefault' => Yii::t( 'app_dict_data', 'Is Default' ),
        'sort' => Yii::t( 'app_dict_data', 'Sort' ),
        'status' => Yii::t( 'app_dict_data', 'Status' ),
        'createdAt' => Yii::t( 'app_dict_data', 'Created At' ),
        'updatedAt' => Yii::t( 'app_dict_data', 'Updated At' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeHints() {

    return [
        'isDefault' => '0:否|1:是',
        'status' => '0:不可用|1:可用'
    ];

  }

  public static function getDataList( $dict_type ) {

    return self::find()->where( [
        'dictType' => $dict_type
    ] )->orderBy( 'sort' )->all();

  }

  /**
   *
   * {@inheritdoc}
   * @return DictDataQuery the active query used by this AR class.
   */
  public static function find() {

    return new DictDataQuery( get_called_class() );

  }
}
