<?php
namespace DuAdmin\Api;

use DuAdmin\Core\ActionTrait;
use yii\base\Action;

/**
 * 基础Action
 *
 * 注意的问题：
 * 多个不同类型的模型的时候使用formName区分不同的模型参数
 * 很关键，不然导致参数交叉赋值
 * 当我们的url传参的时候没有使用formName[field]格式的时候，如id=2
 * 会导致每个模型都会加载id=2的参数
 * 开发实践 auth_item , auth_item_child, 角色 赋权限的时候发生
 * 发生该问题的情况是，
 * baseAction的部分方法是贪婪识别参数的，尽量保证参数都被模型加载
 *
 * 如果是action操作的一个模型，是没有问题的
 *
 *
 * @author dungang
 * @property BaseController $controller 控制器
 * @property array $modelBehaviors 模型的行为
 * @property array $actionBehaviors action的行为
 */
abstract class BaseAction extends Action
{

    use ActionTrait;

    const EVENT_BEFORE_RUN = 'actionBeforeRun';

    const EVENT_AFTER_RUN = 'actionAfterRun';

    public function init()
    {
        $this->initAction();
    }

}