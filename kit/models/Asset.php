<?php
namespace app\kit\models;

/**
 * "asset"表的模型类.
 *
 * @property int $id
 * @property string $name 类名
 * @property bool $is_active 有效
 * @property string $baseUrl 基础地址
 * @property string $css CSS文件
 * @property string $js JS文件
 * @property string $level 级别
 */
class Asset extends \app\kit\core\BaseModel
{

    const CacheKey = 'code.assets';

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%asset}}';
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
                    'name','level'
                ],
                'required'
            ],
            [
                [
                    'is_active'
                ],
                'boolean'
            ],
            [
                [
                    'css',
                    'js'
                ],
                'string'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'baseUrl'
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '类名',
            'is_active' => '有效',
            'baseUrl' => '基础地址',
            'css' => 'CSS文件',
            'js' => 'JS文件',
            'level' => '级别'
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'name' => '比如:\yii\assets\JqueryAsset',
            'baseUrl' => 'baseUrl,比如:http://cnd.bootcss.com',
            'css' => '可以用逗号分割多个，比如：css/base.css,css/main.css',
            'js' => '可以用逗号分割多个，比如：js/base.js,css/main.js',
            'level' => 'common表示公共的,frontend表示前端默认，其他级别根据模块的英文名填入，比如:backend'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return AssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetQuery(get_called_class());
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'app\kit\behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CacheKey => [
                    __CLASS__,
                    'getActiveAssetsData'
                ]
            ]
        ];
        return $b;
    }

    public static function getActiveAssetsData()
    {
        $assets = [];
        if ($vars = self::find()->where('is_active=1')->all()) {

            foreach ($vars as $var) {
                if(!isset($assets[$var->level])) {
                    $assets[$var->level] = [];
                }
                $assets[$var->level][$var->name] = [
                    'sourcePath' => null
                ];
                $assets[$var->level][$var->name]['baseUrl'] = $var->baseUrl;
                if ($var->css) {
                    $assets[$var->level][$var->name]['css'] = explode(',', trim($var->css));
                }
                if ($var->js) {
                    $assets[$var->level][$var->name]['js'] = explode(',', trim($var->js));
                }
            }
        }
        return $assets;
    }

    public static function getActiveAssets()
    {
        return \Yii::$app->cache->getOrSet(self::CacheKey, function () {
            return self::getActiveAssetsData();
        });
    }
}
