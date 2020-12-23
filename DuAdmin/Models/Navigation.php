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
 * @property string $url 链接
 * @property int $requireLogin 需要登录
 * @property string $icon ICON
 * @property string $app 应用::默认是前端
 * @property int $sort 排序
 */
class Navigation extends \DuAdmin\Core\BaseModel
{

    const CacheKey = 'front.navigations';

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
    public static function tableName()
    {
        return '{{%navigation}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                'pid',
                'default',
                'value' => '0'
            ],
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
                    'requireLogin',
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'requireLogin' => Yii::t('app', 'Require Login'),
            'icon' => Yii::t('app', 'Icon'),
            'app' => Yii::t('app', 'App'),
            'sort' => Yii::t('app', 'Sort')
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'app' => '默认是前端'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return NavigationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NavigationQuery(get_called_class());
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'DuAdmin\Behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CacheKey => [
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
    public static function getNavigationData()
    {
        $items = self::find()->select('id,pid,name as label,url,icon,requireLogin,app')
            ->indexBy('id')
            ->asArray()
            ->orderBy('sort asc')
            ->all();
        $appItems = [];
        foreach ($items as $item) {
            if (! isset($appItems[$item['app']])) {
                $appItems[$item['app']] = [];
            }
            $appItems[$item['app']][] = $item;
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
    public static function getNavigation($app = 'frontend')
    {
        $appItems = \Yii::$app->cache->getOrSet(self::CacheKey, function () {
            return self::getNavigationData();
        });

        if (isset($appItems[$app])) {
            $items = $appItems[$app];
        } else {
            $items = isset($appItems['frontend']) ?: null;
        }
        if ($items) {
            return AppHelper::listToTree(array_map(function ($item) {
                $item['label'] = Yii::t('app', $item['label']);
                return $item;
            }, $items));
        }
        return [];
    }
}
