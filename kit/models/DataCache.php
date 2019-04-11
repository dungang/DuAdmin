<?php

namespace app\kit\models;

/**
 * "sys_data_cache"表的模型类.
 *
 * @property int $id
 * @property string $name 名称
 * @property string $cache_key 缓存key
 * @property string $cache_handler 缓存处理器
 * @property int $expired 过期时间
 * @property string $intro 介绍
 */
class DataCache extends \app\kit\core\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_data_cache';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cache_key', 'cache_handler'], 'required'],
            [['cache_key'], 'unique'],
            [['expired'], 'integer'],
            [['name', 'cache_key', 'cache_handler'], 'string', 'max' => 128],
            [['intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'cache_key' => '缓存key',
            'cache_handler' => '缓存处理器',
            'expired' => '过期时间',
            'intro' => '介绍',
        ];
    }

    /**
     * {@inheritdoc}
     * @return DataCacheQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DataCacheQuery(get_called_class());
    }
}
