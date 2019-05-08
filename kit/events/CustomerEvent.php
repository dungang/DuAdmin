<?php
namespace app\kit\events;

use yii\base\Event;

/**
 *
 * @author dungang
 */
class CustomerEvent extends Event
{
    /**
     * 传递的值
     * @var mixed
     */
    public $payload;
}

