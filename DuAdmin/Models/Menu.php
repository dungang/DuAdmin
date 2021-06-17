<?php

namespace DuAdmin\Models;

use Yii;

/**
 * "{{%menu}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父菜单ID
 * @property string $name 菜单名
 * @property string $url 链接
 * @property int $isOuter 是否外部链接::0:否|1:是
 * @property int $requireAuth 需要鉴权::0:不需要|1:需要
 * @property string $icon ICON
 * @property string $app 所属APP::后台或插件的Id
 * @property int $sort 排序
 */
class Menu extends \DuAdmin\Core\BaseModel {

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

    return '{{%menu}}';

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
                'name'
            ],
            'required'
        ],
        [
            [
                'pid',
                'isOuter',
                'requireAuth',
                'sort'
            ],
            'integer'
        ],
        [
            [
                'name',
                'icon',
                'app'
            ],
            'string',
            'max' => 64
        ],
        [
            [
                'url'
            ],
            'string',
            'max' => 128
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'app_menu', 'ID' ),
        'pid' => Yii::t( 'app_menu', 'Pid' ),
        'name' => Yii::t( 'app_menu', 'Name' ),
        'url' => Yii::t( 'app_menu', 'Url' ),
        'isOuter' => Yii::t( 'app_menu', 'Is Outer' ),
        'requireAuth' => Yii::t( 'app_menu', 'Require Auth' ),
        'icon' => Yii::t( 'app_menu', 'Icon' ),
        'app' => Yii::t( 'app_menu', 'App' ),
        'sort' => Yii::t( 'app_menu', 'Sort' )
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeHints() {

    return [
        'isOuter' => '0:否|1:是',
        'requireAuth' => '0:不需要|1:需要',
        'app' => '后台或插件的Id'
    ];

  }

  /**
   *
   * {@inheritdoc}
   * @return MenuQuery the active query used by this AR class.
   */
  public static function find() {

    return new MenuQuery( get_called_class() );

  }

  const CacheKeyBack = 'back.menus';

  public function behaviors() {

    $b = parent::behaviors();
    $b ['cleanCache'] = [
        'class' => '\DuAdmin\Behaviors\ReCacheBehavior',
        'cache_keys' => [
            self::CacheKeyBack => [
                __CLASS__,
                'getBackendMenusData'
            ]
        ]
    ];
    return $b;

  }

  public static function getBackendMenusData() {

    $vars = self::find()->select( 'id,pid,name as label,url,icon,requireAuth,isOuter' )->indexBy( 'id' )->asArray()->orderBy( 'sort asc' )->all();
    return $vars;

  }

  public static function getBackMenus() {

    return \Yii::$app->cache->getOrSet( self::CacheKeyBack, function () {
      return self::getBackendMenusData();
    } );

  }
}
