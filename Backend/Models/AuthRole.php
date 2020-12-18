<?php
namespace Backend\Models;

use DuAdmin\Rbac\Item;

class AuthRole extends AuthItem
{

    public function init()
    {
        $this->type = Item::TYPE_ROLE;
    }
}

