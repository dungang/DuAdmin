<?php
namespace app\mmadmin\hooks;

use app\mmadmin\core\Hook;

/**
 * 用户注册的时候
 */
class RegisterUserHook extends Hook {

    /**
     * 注册的用户和信息
     * @var \app\mmadmin\models\User
     */
    public $user;
}