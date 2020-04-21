<?php
namespace app\kit\hooks;

use app\kit\core\Hook;

/**
 * 用户更新的时候
 */
class UpdateUserHook extends Hook {

    /**
     * 更新的用户和信息
     * @var \app\kit\models\User
     */
    public $user;
}