<?php
namespace DuAdmin\Behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\InvalidArgumentException;

/**
 *
 * @author dungang
 */
class ReCacheBehavior extends Behavior
{

    /**
     * 缓存的key
     *
     * @var array
     */
    public $cache_keys;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'updateCache',
            ActiveRecord::EVENT_AFTER_INSERT => 'updateCache'
        ];
    }

    public function updateCache($event)
    {
        if ($this->cache_keys && \is_array($this->cache_keys)) {
            foreach ($this->cache_keys as $key => $callback) {
                if (\is_callable($callback)) {
                    \Yii::$app->cache->set($key, \call_user_func($callback));
                } else {
                    throw new InvalidArgumentException('callback不可回调执行');
                }
            }
        }
    }
}

