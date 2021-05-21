<?php
/**
 * Created by PhpStorm.
 * User: dungang
 * Date: 20-11-22
 * Time: 上午8:53
 */

namespace DuAdmin\Core;


interface Authable
{

     function isSuperAdmin():bool;

     function isActiveAccount():bool;
}