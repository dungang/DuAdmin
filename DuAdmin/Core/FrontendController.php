<?php

namespace DuAdmin\Core;

use DuAdmin\Hooks\FontendCtrInitedHook;
use DuAdmin\Filters\AccessFilter;
/**
 * 前端控制器基类
 * 不需要登陆
 * @author Lenovo
 *
 */
abstract class FrontendController extends BaseController {
    
    public $layout = '//frontend';
    
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
        //注册限流行为
        $bs['post_rate_limit'] = 'DuAdmin\Filters\PostRateLimitFilter';
        return $bs;
    }
}
