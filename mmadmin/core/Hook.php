<?php

namespace app\mmadmin\core;

use app\mmadmin\helpers\KitHelper;
use ReflectionFunction;
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
     * 所有者
     * @var \yii\base\BaseObject;
     */
    public $owner;

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
     * @param app\mmadmin\hooks\Handler | callable  $handler
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
     * @param yii\base\BaseObject $owner 所有者
     * @param array $config 配置hook的属性
     * @return Hook
     */
    public static function emit($owner, $config = [])
    {
        $hookName = static::class;
        if (isset(self::$hooks[$hookName])) {
            $config['owner'] = $owner;
            $hook = new $hookName($config);
            foreach (self::$hooks[$hookName] as $handler) {
                if (is_callable($handler)) {
                    call_user_func($handler, $hook);
                    if (KitHelper::isDevMode()) {
                        $caller = (new ReflectionFunction($handler));
                        Yii::trace($hookName . ' : callback in ' . $caller->getFileName() . ' on ' . $caller->getStartLine());
                    }
                } else {
                    call_user_func([new $handler, 'process'], $hook);
                    Yii::trace($hookName . ' : ' . $handler);
                }
                if ($hook->stop) {
                    break;
                }
            }
            return $hook;
        }
        return null;
    }
}
