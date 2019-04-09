<?php
namespace app\kit\models;

/**
 * "sys_asset"表的模型类.
 *
 * @property int $id
 * @property string $name 类名
 * @property bool $is_active 有效
 * @property string $baseUrl 基础地址
 * @property string $css CSS文件
 * @property string $js JS文件
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
        return 'sys_asset';
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
            'js' => 'JS文件'
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
            'js' => '可以用逗号分割多个，比如：js/base.js,css/main.js'
        ];
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'app\kit\behaviors\CleanCacheBehavior',
            'cacheKey' => self::CacheKey
        ];
        return $b;
    }

    public static function getActiveAssets()
    {
        if (! ($assets = \Yii::$app->cache->get(self::CacheKey))) {
            if ($vars = self::find()->where('is_active=1')->all()) {
                $assets = [];
                foreach ($vars as $var) {
                    $assets[$var->name] = [
                        'sourcePath' => null
                    ];

                    $assets[$var->name]['baseUrl'] = $var->baseUrl;
                    if ($var->css) {
                        $assets[$var->name]['css'] = explode(',', trim($var->css));
                    }
                    if ($var->js) {
                        $assets[$var->name]['js'] = explode(',', trim($var->js));
                    }
                }
            }

            \Yii::$app->cache->set(self::CacheKey, $assets);
        }
        return $assets;
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
}
