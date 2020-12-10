<?php
namespace DuAdmin\Core;

use DuAdmin\Hooks\GuestCtrInitedHook;

/**
 * 游客控制器
 * 不需要登陆
 * @author dungang<dungang@126.com>
 * @date 2020-12-10 8:28:19
 *
 */
abstract class GuestController extends BaseController
{
 
    public function init() {
        parent::init();
        GuestCtrInitedHook::emit($this);
    }
    
    public function behaviors() {
        $bs = parent::behaviors();
        
        //注册限流行为
        $bs['post_rate_limit'] = 'DuAdmin\Filters\PostRateLimitFilter';
        return $bs;
    }
}

