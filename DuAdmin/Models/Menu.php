<?php

namespace DuAdmin\Models;

use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $url 链接
 * @property bool $isFront 是否前端
 * @property bool $requireAuth 需要登录
 * @property int $pid 父节点
 * @property string $icon 图标
 * @property int $sort 排序
 */
class Menu extends \DuAdmin\Core\BaseModel
{

    const CacheKeyFront = 'front.menus';

    const CacheKeyBack = 'back.menus';

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name'
                ],
                'required'
            ],
            [
                [
                    'isFront',
                    'requireAuth'
                ],
                'boolean'
            ],
            [
                [
                    'pid',
                    'sort'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'icon'
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'url' => '链接',
            'isFront' => '是否前端',
            'requireAuth' => '需要鉴权',
            'pid' => '父节点',
            'icon' => '图标',
            'sort' => '排序'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'DuAdmin\Behaviors\ReCacheBehavior',
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
        return self::find()->select('id,pid,name as label,url,icon,requireAuth')
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
        $vars = self::find()->select('id,pid,name as label,url,icon,requireAuth')
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
