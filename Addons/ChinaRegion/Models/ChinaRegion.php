<?php

namespace Addons\ChinaRegion\Models;

use Yii;
/**
 * "{{%china_region}}"表的模型类.
 *
 * @property int $id 行政编码
 * @property int $pid 上级行政编码
 * @property int $level 级别::1:省级|2:市级|3:县级
 * @property string $name 名称
 */
class ChinaRegion extends \DuAdmin\Core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%china_region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pid', 'level'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('addon_china_region', 'ID'),
            'pid' => Yii::t('addon_china_region', 'Pid'),
            'level' => Yii::t('addon_china_region', 'Level'),
            'name' => Yii::t('addon_china_region', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'level' => '1:省级|2:市级|3:县级',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ChinaRegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChinaRegionQuery(get_called_class());
    }
    
    /**
     * 根据regionId序列显示名称
     *
     * @param array $regionIds
     * @return string
     */
    public static function show($regionIds)
    {
        if (is_array($regionIds)) {
            if ($regionIds = array_filter($regionIds)) {
                $names = array_map(function ($region) {
                    return $region['name'];
                }, static::find()->select('name')
                ->where([
                    'id' => array_filter($regionIds)
                ])
                ->asArray()
                ->all());
                    return implode(' ', $names);
            }
        }
        return '';
    }
}