<?php

namespace DuAdmin\Models;

use DuAdmin\Core\BaseModel;
use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * "{{%navigation}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父导航D
 * @property string $name 导航名
 * @property string $intro 导航名
 * @property string $url 地址::可以是内部和外部地址
 * @property int $isOuter 是否外部链接::0:否|1:是
 * @property int $requireAuth 需要登录::0:不需要|1:需要
 * @property string $icon ICON
 * @property string $app 所属APP::前台或后台或插件的Id
 * @property int $sort 排序
 */
class Navigation extends BaseModel
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
        return '{{%navigation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'name'], 'required'],
            [['pid', 'isOuter', 'requireAuth', 'sort'], 'integer'],
            [['name', 'icon', 'app'], 'string', 'max' => 64],
            [['url', 'intro'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app_navigation', 'ID'),
            'pid'          => Yii::t('app_navigation', 'Pid'),
            'name'         => Yii::t('app_navigation', 'Name'),
            'intro'        => Yii::t('app_navigation', 'Intro'),
            'url'          => Yii::t('app_navigation', 'Url'),
            'isOuter'      => Yii::t('app_navigation', 'Is Outer'),
            'requireAuth' => Yii::t('app_navigation', 'Require Login'),
            'icon'         => Yii::t('app_navigation', 'Icon'),
            'app'          => Yii::t('app_navigation', 'App'),
            'sort'         => Yii::t('app_navigation', 'Sort'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'url'          => '可以是内部和外部地址',
            'isOuter'      => '0:否|1:是',
            'requireAuth' => '0:不需要|1:需要',
            'app'          => '前台或后台或插件的Id',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NavigationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NavigationQuery(get_called_class());
    }

    const CACHE_KEY = 'fontend.navigations';
    const CACHE_GUEST_KEY = 'fontend.guest.navigations';

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class'      => 'DuAdmin\Behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CACHE_KEY       => [
                    __CLASS__,
                    'getNavigationData'
                ],
                self::CACHE_GUEST_KEY => [
                    __CLASS__,
                    'getGuestNavigationData'
                ],
            ]
        ];
        return $b;
    }

    /**
     * 获取导航数据
     *
     * @return Navigation[]|array
     */
    public static function getNavigationData()
    {
        return self::find()
            ->where('requireAuth = 1')
            ->indexBy('id')
            ->asArray()
            ->orderBy('sort asc')
            ->all();
    }

    /**
     * 获取导航数据
     *
     * @return Navigation[]|array
     */
    public static function getGuestNavigationData()
    {
        return self::find()
            ->where('requireAuth = 0')
            ->indexBy('id')
            ->asArray()
            ->orderBy('sort asc')
            ->all();
    }

    public static function formatBootstrapMenuItem($items)
    {
        $appItems = [];
        foreach ($items as $item) {
            $item['label'] = Yii::t('app', $item['name']);
            $item['linkOptions'] = [
                'title' => empty($item['intro']) ? '' : $item['intro']
            ];
            if (empty($item['isOuter'])) {
                $item['url'] = AppHelper::parseDuAdminMenuUrl($item['url'], '/');
            } else {
                $item['linkOptions']['target'] = '_blank';
            }
            $appItems[] = $item;
        }
        return $appItems;
    }

    public static function getAllItems($guest)
    {
        if ($guest) {
            return \Yii::$app->cache->getOrSet(self::CACHE_GUEST_KEY, function () {
                return self::getGuestNavigationData();
            });
        } else {
            return  \Yii::$app->cache->getOrSet(self::CACHE_KEY, function () {
                return self::getNavigationData();
            });
        }
    }

    /**
     * 根据app编码获取对应的导航
     * 如果对应的app没有数据默认使用frontend
     *
     * @param string $app
     * @return array|array[]
     */
    public static function getNavigation($app = 'frontend', $guest = false)
    {

        if ($appItems = static::getAllItems($guest)) {
            return array_filter($appItems, function ($item) use ($app) {
                return $item['app'] == $app;
            });
        } else {
            return [];
        }
    }

    /**
     * 根据app编码获取对应的导航
     * 如果对应的app没有数据默认使用frontend
     *
     * @param string $app
     * @return array|array[]
     */
    public static function getNavigationExclude($app = 'frontend', $guest = false)
    {

        if ($appItems = static::getAllItems($guest)) {
            return array_filter($appItems, function ($item) use ($app) {
                return $item['app'] !== $app;
            });
        } else {
            return [];
        }
    }

    public static function getBootstapNavigation($app, $guest = false)
    {
        $items = static::getNavigation($app, $guest);
        if ($items) {
            return AppHelper::listToTree(static::formatBootstrapMenuItem($items), 'id', 'pid', 'items');
        }
        return [];
    }
}
