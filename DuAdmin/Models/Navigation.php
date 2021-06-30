<?php

namespace DuAdmin\Models;

use Yii;
use DuAdmin\Helpers\AppHelper;

/**
 * "{{%navigation}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父导航D
 * @property string $name 导航名
 * @property string $url 地址::可以是内部和外部地址
 * @property int $isOuter 是否外部链接::0:否|1:是
 * @property int $requireLogin 需要登录::0:不需要|1:需要
 * @property string $icon ICON
 * @property string $app 所属APP::前台或后台或插件的Id
 * @property int $sort 排序
 */
class Navigation extends \DuAdmin\Core\BaseModel {
    ///**
    // * 对象json序列化的时候设置不显示的字段
    // *
    // * @var array
    // */
    // public $jsonHideFields = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%navigation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [ [ 'pid', 'name' ], 'required' ],
            [ [ 'pid', 'isOuter', 'requireLogin', 'sort' ], 'integer' ],
            [ [ 'name', 'icon', 'app' ], 'string', 'max' => 64 ],
            [ [ 'url' ], 'string', 'max' => 128 ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'           => Yii::t( 'app_navigation', 'ID' ),
            'pid'          => Yii::t( 'app_navigation', 'Pid' ),
            'name'         => Yii::t( 'app_navigation', 'Name' ),
            'url'          => Yii::t( 'app_navigation', 'Url' ),
            'isOuter'      => Yii::t( 'app_navigation', 'Is Outer' ),
            'requireLogin' => Yii::t( 'app_navigation', 'Require Login' ),
            'icon'         => Yii::t( 'app_navigation', 'Icon' ),
            'app'          => Yii::t( 'app_navigation', 'App' ),
            'sort'         => Yii::t( 'app_navigation', 'Sort' ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints() {
        return [
            'url'          => '可以是内部和外部地址',
            'isOuter'      => '0:否|1:是',
            'requireLogin' => '0:不需要|1:需要',
            'app'          => '前台或后台或插件的Id',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NavigationQuery the active query used by this AR class.
     */
    public static function find() {
        return new NavigationQuery( get_called_class() );
    }

    const CACHE_KEY = 'fontend.navigations';

    public function behaviors() {
        $b = parent::behaviors();
        $b[ 'cleanCache' ] = [
            'class'      => 'DuAdmin\Behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CACHE_KEY => [
                    __CLASS__,
                    'getNavigationData'
                ]
            ]
        ];
        return $b;
    }

    /**
     * 获取导航数据
     *
     * @return \DuAdmin\Models\Navigation[]|array
     */
    public static function getNavigationData() {
        $items = self::find()
            ->indexBy( 'id' )
            ->asArray()
            ->orderBy( 'sort asc' )
            ->all();
        $appItems = [];
        foreach ( $items as $item ) {
            if ( !isset( $appItems[ $item[ 'app' ] ] ) ) {
                $appItems[ $item[ 'app' ] ] = [];
            }
            $appItems[ $item[ 'app' ] ][] = $item;
        }
        return $appItems;
    }

    /**
     * 根据app编码获取对应的导航
     * 如果对应的app没有数据默认使用frontend
     *
     * @param string $app
     * @return array|array[]
     */
    public static function getNavigation( $app = 'frontend' ) {
        $appItems = \Yii::$app->cache->getOrSet( self::CACHE_KEY, function () {
            return self::getNavigationData();
        } );

        if ( isset( $appItems[ $app ] ) ) {
            $items = $appItems[ $app ];
        } else {
            $items = isset( $appItems[ 'frontend' ] ) ?: null;
        }
        if ( $items ) {
            return AppHelper::listToTree( array_map( function ( $item ) {
                        $item[ 'label' ] = Yii::t( 'app', $item[ 'name' ] );
                        return $item;
                    }, $items ), 'id', 'pid', 'items' );
        }
        return [];
    }

}
