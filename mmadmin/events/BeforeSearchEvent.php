<?php

namespace app\mmadmin\events;

use yii\base\Event;

/**
 * 搜索模型搜索事件
 */
class BeforeSearchEvent extends Event
{
    /**
     * 查询对象
     *
     * @var \yii\db\ActiveQuery 
     */
    public $query;

    /**
     * 查询参数
     *
     * @var array
     */
    public $params;

}