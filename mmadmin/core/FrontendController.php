<?php

namespace app\mmadmin\core;

use app\mmadmin\hooks\FontendCtrInitedHook;
/**
 * 前端控制器基类
 * 不需要登陆
 * @author Lenovo
 *
 */
abstract class FrontendController extends BaseController {

    public function init() {
        parent::init();
        FontendCtrInitedHook::emit($this);
    }

    public function behaviors() {
        $bs = parent::behaviors();
        //注册限流行为
        $bs['post_rate_limit'] = 'app\mmadmin\filters\PostRateLimitFilter';
        return $bs;
    }
}
