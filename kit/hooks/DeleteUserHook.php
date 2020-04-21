<?php
namespace app\kit\hooks;

use app\kit\core\Hook;

/**
 * 用户删除的时候
 */
class DeleteUserHook extends Hook {

    /**
     * 注册的用户和信息
     * @var \app\kit\models\User
     */
    public $user;
}