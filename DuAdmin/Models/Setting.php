<?php
namespace DuAdmin\Models;

use Yii;
/**
 * This is the model class for table "setting".
 *
 * @property string $name 名称
 * @property string $parent 归属
 * @property string $title 标题
 * @property string $value 值
 * @property string $hint 提示
 * @property string $valType 值类型
 * @property string $category 参数分类
 */
class Setting extends \DuAdmin\Core\BaseModel
{

    const CacheKey = 'setting.vars';

    public static $settings;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
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
                    'name',
                    'title'
                ],
                'required'
            ],
            [
                [
                    'value',
                    'valType'
                ],
                'string'
            ],
            [
                [
                    'name',
                    'parent',
                    'title',
                    'category'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'hint'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'name'
                ],
                'unique'
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
            'name' => Yii::t('app_setting', 'Name'),
            'parent' => Yii::t('app_setting', 'Parent'),
            'title' => Yii::t('app_setting', 'Title'),
            'value' => Yii::t('app_setting', 'Value'),
            'hint' => Yii::t('app_setting', 'Hint'),
            'valType' => Yii::t('app_setting', 'Val Type'),
            'category' => Yii::t('app_setting', 'Category'),
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
    }

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['re-cache'] = [
            'class' => 'DuAdmin\Behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CacheKey => [
                    __CLASS__,
                    'getSettingsData'
                ]
            ]
        ];
        return $b;
    }

    public static function getSettingsData()
    {
        return self::find()->indexBy('name')
            ->asArray()
            ->all();
    }

    public static function getCacheSettings()
    {
        return \Yii::$app->cache->getOrSet(self::CacheKey, function () {
            return self::getSettingsData();
        });
    }

    public static function getSettingCatetory()
    {
        $categories = [];
        if ($setting = self::findOne([
            'name' => 'setting.category'
        ])) {
            if (! empty($setting->value)) {
                $items = \explode("\n", trim($setting->value));
                foreach ($items as $item) {
                    $kv = explode(':', $item);
                    $categories[$kv[0]] = $kv[1];
                }
            }
        }
        return $categories;
    }

    /**
     * 以关联数组形式的返回参数值
     *
     * @param string $name
     * @return mixed[]
     */
    public static function getSettingAssoc($name)
    {
        $assoc = [];
        $val = self::getSettings($name);
        $items = \explode("\n", trim($val));
        foreach ($items as $item) {
            if ($item) {
                $match = [];
                if (\preg_match('#^(.*?):(.*?)$#i', $item, $match)) {
                    $assoc[$match[1]] = trim($match[2]);
                }
            }
        }
        return $assoc;
    }

    /**
     * 数组形式的返回参数值
     *
     * @param string $name
     * @return array
     */
    public static function getSettingAry($name)
    {
        $val = self::getSettings($name, '');
        return \explode("\n", trim($val));
    }

    public static function getSettings($name, $default = NULL)
    {
        if (! self::$settings) {
            self::$settings = self::getCacheSettings();
        }
        if (self::$settings && isset(self::$settings[$name])) {
            return self::$settings[$name]['value'];
        }
        return $default;
    }
}
