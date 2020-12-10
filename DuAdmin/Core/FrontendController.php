<?php

namespace DuAdmin\Core;

use DuAdmin\Hooks\FontendCtrInitedHook;
use DuAdmin\Filters\AccessFilter;
/**
 * 前端控制器基类
 * 需要登陆
 * @author Lenovo
 *
 */
abstract class FrontendController extends BaseController {
    
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
    

    public function init() {
        parent::init();
        FontendCtrInitedHook::emit($this);
    }

    public function behaviors() {
        $bs = parent::behaviors();
        //注册访问控制行为
        //必须把行为放在第一个位置
        array_unshift($bs,AccessFilter::class);
        return $bs;
    }
}
