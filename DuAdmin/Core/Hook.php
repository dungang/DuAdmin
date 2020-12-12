<?php

namespace DuAdmin\Core;

use DuAdmin\Helpers\AppHelper;
use ReflectionFunction;
use Yii;
use yii\base\BaseObject;

/**
 * 钩子，由于yii框架的自带了以组件为单位的事件机制，占用了event的概念，
 * 为了区分，所以 用hook 代替了应用级别的事件
 * 
 * 处理付款等行为后激活服务的功能
 * 不使用hook的原因是，yii默认在事件机制是在一个事务里的，
 * 如果hook处理异常会导致事务回滚，但是某些情况我们希望不要回滚，
 * 比如，订单付款成功后的同步通知或者异步通知，
 * 我们必须要保证订单的状态保存成功为已支付状态，而不能因为其他的业务异常回滚。
 * 总结为：单有异步（第三方）的业务不可回滚的情况，不要使用hook，除非Hook支持异步的，不影响事务。
 * hook是一次性，不会在次触发，也不适合付款的场景
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
     * @param string | callable  $handlerName
     * @param boolean $addHeader hook添加在头还是队列的尾
     * @return void
     */
    public static function registerHandler($handlerName, $addHeader = false)
    {
        static::registerHookHandler(get_called_class(), $handlerName, $addHeader);
    }
    
    /**
     * 注册监听hook的处理器
     * @param string $hookName
     * @param string | callable  $handlerName
     * @param boolean $addHeader hook添加在头还是队列的尾
     * @return void
     */
    public static function registerHookHandler(string $hookName, $handlerName,$addHeader = false) {
        
        if (empty(self::$hooks[$hookName])) {
            self::$hooks[$hookName] = array();
        }
        if ($addHeader) {
            array_unshift(self::$hooks[$hookName], $handlerName);
        } else {
            self::$hooks[$hookName][] = $handlerName;
        }
    }

    /**
     * 处罚hook
     * @param yii\base\BaseObject $owner 所有者
     * @param array $config 配置hook的属性
     * @return Hook|null
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
                    if (AppHelper::isDevMode()) {
                        $caller = (new ReflectionFunction($handler));
                        Yii::debug($hookName . ' : callback in ' . $caller->getFileName() . ' on ' . $caller->getStartLine());
                    }
                } else {
                    call_user_func([new $handler, 'process'], $hook);
                    Yii::debug($hookName . ' : ' . $handler);
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
