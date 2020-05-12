<?php
namespace app\mmadmin\widgets;

class AdminlteNavBarNotifications extends AdminlteNavBarDropdownMenu
{

    protected function renderItem($item)
    {
        return '<a href="#">
                  <i class="fa fa-users text-aqua"></i> 5 new members joined today
                </a>';
    }
}

