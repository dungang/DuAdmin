<?php
namespace DuAdmin\Cron;

use yii\base\BaseObject;
use DuAdmin\Models\Cron;

abstract class BaseJob extends BaseObject
{
    /**
     * 
     * @param array $params
     * @param Cron $cron
     */
    public abstract function handle($params,$cron);
}

