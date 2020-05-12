<?php
namespace app\mmadmin\hooks;

use app\mmadmin\core\Hook;

/**
 * 用户删除的时候
 */
class DeleteUserHook extends Hook {

    /**
     * 注册的用户和信息
     * @var \app\mmadmin\models\User
     */
    public $user;
}