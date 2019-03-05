<?php
namespace app\kit\models;

use app\kit\helpers\MiscHelper;

/**
 * This is the model class for table "gt_menu".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $url 链接
 * @property bool $is_front 是否前端
 * @property int $pid 父节点
 * @property string $icon 图标
 * @property int $sort 排序
 */
class Menu extends \app\kit\core\BaseModel
{

    const CacheKeyFront = 'front.menus';

    const CacheKeyBack = 'back.menus';

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gt_menu';
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'app\kit\behaviors\CleanCacheBehavior',
            'cacheKey' => [
                self::CacheKeyFront,
                self::CacheKeyBack
            ]
        ];
        return $b;
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
                    'is_front'
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
            'is_front' => '是否前端',
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

    public static function getFrontMenus()
    {
        if (! ($vars = \Yii::$app->cache->get(self::CacheKeyFront))) {
            $vars = self::find()->select('id,pid,name as label,url')->where([
                'is_front' => 1
            ])
                ->indexBy('id')
                ->asArray()
                ->orderBy('sort asc')
                ->all();
            if ($vars) {
                $vars = MiscHelper::listToTree($vars);
            }
            \Yii::$app->cache->set(self::CacheKeyFront, $vars);
        }
        return $vars;
    }

    public static function getBackMenus()
    {
        if (! ($vars = \Yii::$app->cache->get(self::CacheKeyBack))) {
            $vars = self::find()->select('id,pid,name as label,url')->where([
                'is_front' => 0
            ])
                ->indexBy('id')
                ->asArray()
                ->orderBy('sort asc')
                ->all();
            if ($vars) {
                $vars = MiscHelper::listToTree($vars);
            }
            \Yii::$app->cache->set(self::CacheKeyBack, $vars);
        }
        return $vars;
    }
}
