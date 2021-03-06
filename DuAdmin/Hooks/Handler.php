<?php
namespace DuAdmin\Hooks;

use yii\base\BaseObject;

/**
 *  事件处理的抽象句柄
 *  此业务的目标是增强yii的事件，支持代码外部配置自定义的事件和内置事件
 *  并不影响yii本身的事件机制
 *  关联数据表 : ma_event, ma_event_handler
 * @author dungang
 */
abstract class Handler extends BaseObject
{
    /**
     * 事件处理接口方法
     *
     * @param \DuAdmin\Core\Hook $hook
     * @return void
     */
    public abstract function process($hook);
}
