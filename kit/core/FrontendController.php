<?php

namespace app\kit\core;

use app\kit\hooks\FontendCtrInitedHook;
/**
 * 前端控制器基类
 * 不需要登陆
 * @author Lenovo
 *
 */
abstract class FrontendController extends BaseController {

    public function init() {
        parent::init();
        FontendCtrInitedHook::emit();
    }

    public function behaviors() {
        $bs = parent::behaviors();
        //注册限流行为
        $bs['post_rate_limit'] = 'app\kit\filters\PostRateLimitFilter';
        return $bs;
    }

    protected function loadBehaviors() {
        return $this->loadConfig("behaviors-frontend.php");
    }

}
