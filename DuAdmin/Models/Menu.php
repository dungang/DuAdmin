<?php

namespace DuAdmin\Models;

use Yii;
use DuAdmin\Helpers\AppHelper;
/**
 * "{{%menu}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父菜单ID
 * @property string $name 菜单名
 * @property string $url 链接
 * @property int $isFront 是否前端::0:后端|1:前端
 * @property int $isOuter 是否外部链接::0:否|1:是
 * @property int $requireAuth 需要鉴权::0:不需要|1:需要
 * @property string $icon ICON
 * @property string $app 所属APP::后台或插件的Id
 * @property int $sort 排序
 */
class Menu extends \DuAdmin\Core\BaseModel
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
        return '{{%menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'name'], 'required'],
            [['pid', 'isFront', 'isOuter', 'requireAuth', 'sort'], 'integer'],
            [['name', 'icon', 'app'], 'string', 'max' => 64],
            [['url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'isFront' => Yii::t('app', 'Is Front'),
            'isOuter' => Yii::t('app', 'Is Outer'),
            'requireAuth' => Yii::t('app', 'Require Auth'),
            'icon' => Yii::t('app', 'Icon'),
            'app' => Yii::t('app', 'App'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'isFront' => '0:后端|1:前端',
            'isOuter' => '0:否|1:是',
            'requireAuth' => '0:不需要|1:需要',
            'app' => '后台或插件的Id',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    
    const CacheKeyFront = 'front.menus';
    
    const CacheKeyBack = 'back.menus';
    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => '\DuAdmin\Behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CacheKeyFront => [
                    __CLASS__,
                    'getFrontMenusData'
                ],
                self::CacheKeyBack => [
                    __CLASS__,
                    'getBackendMenusData'
                ]
            ]
        ];
        return $b;
    }
    
    public static function getFrontMenusData()
    {
        return self::find()->select('id,pid,name as label,url,icon,requireAuth,isOuter')
        ->where([
            'isFront' => 1
        ])
        ->indexBy('id')
        ->asArray()
        ->orderBy('sort asc')
        ->all();
        // if ($vars) {
        //     $vars = AppHelper::listToTree($vars);
        // }
        // return $vars;
    }
    
    public static function getFrontMenus()
    {
        $menus =  \Yii::$app->cache->getOrSet(self::CacheKeyFront, function () {
            return self::getFrontMenusData();
        });
            return AppHelper::listToTree(array_map(function($menu){
                $menu['label'] = Yii::t('app',$menu['label']);
                return $menu;
            },$menus));
    }
    
    public static function getBackendMenusData()
    {
        $vars = self::find()->select('id,pid,name as label,url,icon,requireAuth,isOuter')
        ->where([
            'isFront' => 0
        ])
        ->indexBy('id')
        ->asArray()
        ->orderBy('sort asc')
        ->all();
        // if ($vars) {
        // $vars = AppHelper::listToTree($vars);
        // }
        return $vars;
    }
    
    public static function getBackMenus()
    {
        return \Yii::$app->cache->getOrSet(self::CacheKeyBack, function () {
            return self::getBackendMenusData();
        });
    }
}
