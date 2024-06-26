<?php

namespace Backend\Models;

use Yii;

/**
 * "{{%auth_item}}"表的模型类.
 *
 * @property string $id ID::路由ID或者角色，组的英文表示
 * @property int $type 类型::1:角色|2:权限|3:组
 * @property string $name 说明
 * @property string $ruleId 规则ID
 * @property resource $data 数据
 * @property int $sort 排序
 * @property string $createdAt 添加时间
 * @property string $updatedAt 更新时间
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $rule
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $parents
 * @property AuthItem[] $children
 */
class AuthItem extends \DuAdmin\Core\BaseModel {

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

    return '{{%auth_item}}';

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            'id',
            'filter',
            'filter' => function ( $value ) {
              return trim( $value, '/' );
            }
        ],
        [
            [
                'id',
                'type'
            ],
            'required'
        ],
        [
            [
                'type',
                'sort'
            ],
            'integer'
        ],
        [
            [
                'data'
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
                'id',
                'name',
                'ruleId'
            ],
            'string',
            'max' => 64
        ],
        [
            [
                'id'
            ],
            'unique'
        ],
        [
            'ruleId',
            'default',
            'value' => null
        ],
        [
            [
                'ruleId'
            ],
            'exist',
            'skipOnError' => true,
            'targetClass' => AuthRule::class,
            'targetAttribute' => [
                'ruleId' => 'id'
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
        'id' => Yii::t( 'app_auth_item', 'ID' ),
        'type' => Yii::t( 'app_auth_item', 'Type' ),
        'name' => Yii::t( 'app_auth_item', 'Name' ),
        'ruleId' => Yii::t( 'app_auth_item', 'Rule ID' ),
        'data' => Yii::t( 'app_auth_item', 'Data' ),
        'sort' => Yii::t( 'app_auth_item', 'Sort' ),
        'createdAt' => Yii::t( 'app_auth_item', 'Created At' ),
        'updatedAt' => Yii::t( 'app_auth_item', 'Updated At' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeHints() {

    return [
        'id' => '路由ID或者角色，组的英文表示',
        'type' => '1:角色|2:权限|3:组'
    ];

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAuthAssignments() {

    return $this->hasMany( AuthAssignment::class, [
        'itemId' => 'id'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getRule() {

    return $this->hasOne( AuthRule::class, [
        'id' => 'ruleId'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAuthItemChildren() {

    return $this->hasMany( AuthItemChild::class, [
        'child' => 'id'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAuthItemChildren0() {

    return $this->hasMany( AuthItemChild::class, [
        'parent' => 'id'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getParents() {

    return $this->hasMany( AuthItem::class, [
        'id' => 'parent'
    ] )->viaTable( '{{%auth_item_child}}', [
        'child' => 'id'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getChildren() {

    return $this->hasMany( AuthItem::class, [
        'id' => 'child'
    ] )->viaTable( '{{%auth_item_child}}', [
        'parent' => 'id'
    ] );

  }

  /**
   *
   * @return \yii\db\ActiveQuery
   */
  public function getParent() {

    return $this->hasOne( AuthItem::class, [
        'id' => 'parent'
    ] )->viaTable( '{{%auth_item_child}}', [
        'child' => 'id'
    ] );

  }

  public function getPid() {

    if ( $this->parent ) {
      return $this->parent->id;
    }
    return null;

  }

  /**
   *
   * {@inheritdoc}
   * @return AuthItemQuery the active query used by this AR class.
   */
  public static function find() {

    return new AuthItemQuery( get_called_class() );

  }
}
