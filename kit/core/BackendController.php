<?php

namespace app\kit\core;

use app\kit\filters\AccessFilter;
use app\kit\hooks\BackendCtrInitedHook;
use app\kit\models\EventHandler;

/**
 * 后端程序控制器基类
 * 需要登陆
 * @author Lenovo
 *
 */
abstract class BackendController extends BaseController {
    
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
        BackendCtrInitedHook::emit();
        $this->module->layoutPath = '@app/backend/views/layouts';
        $this->layout = 'main';
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        //注册访问控制行为
        //必须把行为放在第一个位置
        array_unshift($behaviors,AccessFilter::className());
        return $behaviors;
    }

    protected function loadBehaviors() {
        return $this->loadConfig("behaviors-backend.php");
    }


}
