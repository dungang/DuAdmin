<?php
namespace DuAdmin\Cron;

use yii\base\BaseObject;

/**
 * DuA定时任务驱动
 * @author dungang<dungang@126.com>
 * @since 2020-12-12
 */
abstract class BaseCronDriver extends BaseObject
{
    
    /**
     * 进程运行状态，0表示停止，时间戳表示运行中，表示运行的启动的时间
     */
    const CRON_STATUS_NAME = 'crontab.status';
    
    /**
     * 进程时钟周期记录的时间戳
     */
    const CRON_TRACED_AT_NAME = 'crontab.traced_at';
    
    /**
     * 获取状态
     * @return void
     */
    public abstract function getState();
    
    
    /**
     * 读取状态
     * @return array
     */
    public abstract function setState();
    
}

