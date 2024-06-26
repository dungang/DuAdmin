<?php

namespace DuAdmin\Core;

use DuAdmin\Filters\AccessFilter;

/**
 * 后端程序控制器基类
 * 需要登陆
 *
 * @author Lenovo
 *
 */
abstract class BackendController extends BaseController
{

    public $layout = 'main';
    /**
     * 游客可以访问的action清单
     *
     * @var array
     */
    public $guestActions = [];

    /**
     * 登录用户可以访问的action清单
     *
     * @var array
     */
    public $userActions = [];

    public function init()
    {
        parent::init();
        $this->module->layoutPath = '@Backend/Views/layouts';
    }

    public function behaviors()
    {

        $behaviors = parent::behaviors();
        // 注册访问控制行为
        // 必须把行为放在第一个位置
        array_unshift($behaviors, AccessFilter::class);
        return $behaviors;
    }
}
