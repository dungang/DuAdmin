<?php

namespace DuAdmin\Core;

use Yii;
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

    const EVENT_BEFORE_RENDER = 'actionBeforeRender';

    /**
     * view 文件的名称
     *
     * @var string
     */
    public $viewName;


    /**
     * 成功操作的跳转地址，如果没有设置，则使用默认的
     *
     * @var string
     */
    public $successRediretUrl = false;

    /**
     * 文本消息
     *
     * @var string
     */
    public $successMsg;

    /**
     * 输出到视图的数据
     *
     * @var array
     */
    public $data = [];


    public function init()
    {
        $this->initAction();
        
        if (empty($this->viewName)) {
            $this->viewName = $this->id;
        }
        if (empty($this->successMsg)) {
            $this->successMsg = Yii::t('da', 'Create success');
        }
    }


    /**
     * 试图在渲染之前
     *
     * @return void
     */
    protected function beforeRender()
    {
        $this->trigger(self::EVENT_BEFORE_RENDER);
    }

    /**
     * 计算跳转的参数或url
     *
     * @param BaseModel $model
     * @return mixed[]|string
     */
    protected function getSuccessRediretUrlWidthModel($model)
    {
        if (is_array($this->successRediretUrl)) {
            $url = [];
            $url[] = \array_shift($this->successRediretUrl);
            foreach ($this->successRediretUrl as $p => $f) {
                if (is_numeric($p)) {
                    $url[$f] = $model[$f];
                } else {

                    $url[$p] = $model[$f];
                }
            }
            return $url;
        }
        return $this->successRediretUrl;
    }
}