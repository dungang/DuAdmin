<?php
namespace app\kit\eventhandlers;

use yii\base\BaseObject;

/**
 *
 * @author dungang
 */
abstract class AbstractEventHandler extends BaseObject
{

    public abstract function process($event);
}

