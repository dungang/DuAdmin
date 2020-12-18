<?php

namespace Backend\Models;

use DuAdmin\Rbac\Item;
class AuthGroup extends AuthItem
{
    public function init()
    {
        $this->type = Item::TYPE_GROUP;
    }
}
