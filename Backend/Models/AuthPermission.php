<?php
namespace Backend\Models;

use DuAdmin\Rbac\Item;

/**
 * 系统权限
 *
 * @author dungang
 *        
 */
class AuthPermission extends AuthItem
{
    public function init()
    {
        $this->type = Item::TYPE_PERMISSION;
    }
}

