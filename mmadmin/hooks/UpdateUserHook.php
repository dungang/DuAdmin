<?php
namespace app\mmadmin\hooks;

use app\mmadmin\core\Hook;

/**
 * 用户更新的时候
 */
class UpdateUserHook extends Hook {

    /**
     * 更新的用户和信息
     * @var \app\mmadmin\models\User
     */
    public $user;
}