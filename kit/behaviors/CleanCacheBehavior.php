<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class CleanCacheBehavior extends Behavior
{

    /**
     * 缓存的key
     *
     * @var string|array
     */
    public $cache_keys;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'cleanCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'cleanCache',
            ActiveRecord::EVENT_AFTER_INSERT => 'cleanCache'
        ];
    }

    public function cleanCache($event)
    {
        if ($this->cache_keys) {
            if (is_array($this->cache_keys)) {
                foreach ($this->cache_keys as $key) {
                    \Yii::$app->cache->delete($key);
                }
            } else {
                \Yii::$app->cache->delete($this->cache_keys);
            }
        }
    }
}

