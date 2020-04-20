<?php

namespace app\kit\core;

use Yii;
use yii\base\BaseObject;

/**
 * 钩子，由于yii框架的自带了以组件为单位的事件机制，占用了event的概念，
 * 为了区分，所以 用hook 代替了应用级别的事件
 */
abstract class Hook extends BaseObject
{

    public static $hooks = [];

    /**
     * 承载的数据
     * @var mixed
     */
    public $payload;

    /**
     * 是否停止执行后面的处理器
     * @var boolean
     */
    public $stop = false;

    /**
     * 注册监听hook的处理器
     * @param app\kit\hooks\Handler $handler
     * @param boolean $addHeader hook添加在头还是队列的尾
     */
    public static function registerHandler($handler, $addHeader = false)
    {
        $hookName = static::class;
        if (empty(self::$hooks[$hookName])) {
            self::$hooks[$hookName] = array();
        }
        if ($addHeader) {
            array_unshift(self::$hooks[$hookName], $handler);
        } else {
            self::$hooks[$hookName][] = $handler;
        }
    }

    /**
     * 处罚hook
     * @param array $config 配置hook的属性
     * @return Hook
     */
    public static function emit($config = [])
    {
        $hookName = static::class;
        if (isset(self::$hooks[$hookName])) {
            $hook = new $hookName($config);
            foreach (self::$hooks[$hookName] as $handler) {
                call_user_func([new $handler, 'process'], $hook);
                if ($hook->stop) {
                    break;
                }
            }
            return $hook;
        }
        return null;
    }
}
