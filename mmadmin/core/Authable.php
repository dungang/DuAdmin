<?php
/**
 * Created by PhpStorm.
 * User: dungang
 * Date: 20-11-22
 * Time: 上午8:53
 */

namespace app\mmadmin\core;


interface Authable
{

    public function isSuperAdmin():bool;

    public function isActiveAccount():bool;
}