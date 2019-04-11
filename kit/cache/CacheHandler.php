<?php
namespace kit\cache;

use yii\base\BaseObject;

/**
 *
 * @author dungang
 */
abstract class CacheHandler extends BaseObject
{
    public abstract function fetch();
}

