<?php
namespace DuAdmin\Helpers;

use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * 类定时任务进程管理工具类
 * @author dungang
 */
class CrontabHelper
{

    /**
     * 进程运行状态，0表示停止，时间戳表示运行中，表示运行的启动的时间
     */
    const CRON_STATUS_NAME = 'crontab.status';

    /**
     * 进程时钟周期记录的时间戳
     */
    const CRON_TRACED_AT_NAME = 'crontab.traced_at';
    
    
    const CRON_IS_RUNNING = 'crontab.is_running';

    /**
     * 数据存储的路径
     */
    const CRON_DATA_FILE_BASE = '@runtime/cron/';

    /**
     * 获取定时任务的数据文件
     *
     * @param string $cron_name 进程名称
     * @return string
     */
    private static function getCronDataFile($cron_name = 'data')
    {
        return self::CRON_DATA_FILE_BASE . $cron_name . '.txt';
    }

    /**
     * 读取进程数据文件的内容，并解析成固定的格式的数据
     *
     * @param string $cron_name 进程名称
     * @return array
     */
    private static function readCron($cron_name = 'data')
    {
        $file = \Yii::getAlias(self::getCronDataFile($cron_name));
        if (! \is_file($file)) {
            $dir = \dirname($file);
            if (! \is_dir($dir)) {
                FileHelper::createDirectory($dir);
            }
            \file_put_contents($file, Json::encode([
                self::CRON_STATUS_NAME => 0,
                self::CRON_TRACED_AT_NAME => 0,
                self::CRON_IS_RUNNING => 0
            ]));
        }
        if ($data = \file_get_contents($file)) {
            $data =  Json::decode($data);
        }
        return ArrayHelper::merge([
            self::CRON_STATUS_NAME => 0,
            self::CRON_TRACED_AT_NAME => 0,
            self::CRON_IS_RUNNING => 0
        ], $data);
    }

    /**
     * 保存进程的数据
     *
     * @param array $data
     * @param string $cron_name 进程名称
     * @return void
     */
    private static function writeCron($data, $cron_name = 'data')
    {
        $raw = self::readCron($cron_name);
        $file = \Yii::getAlias(self::getCronDataFile($cron_name));
        \file_put_contents($file, Json::encode(\array_merge($raw, $data)));
    }

    /**
     * 读取进程的数据
     *
     * @param string $cron_name 进程名称
     * @return array
     */
    public static function prepareCronSetting($cron_name = 'data')
    {
        $data = self::readCron($cron_name);

        return [
            $data[self::CRON_STATUS_NAME],
            $data[self::CRON_TRACED_AT_NAME],
            $data[self::CRON_IS_RUNNING]
        ];
    }

    /**
     * 获取进程的状态
     *
     * @param string $cron_name
     * @return int
     */
    public static function getCronStatus($cron_name = 'data')
    {
        return self::readCron($cron_name)[self::CRON_STATUS_NAME];
    }

    /**
     * 激活进程
     *
     * @param string $cron_name 进程名称
     * @return void
     */
    public static function activeCronStatus($cron_name = 'data')
    {
        self::writeCron([
            self::CRON_STATUS_NAME => time(),
            self::CRON_IS_RUNNING => 0,
        ], $cron_name);
    }

    /**
     * 禁用进程
     *
     * @param string $cron_name 进程名称
     * @return void
     */
    public static function unactiveCronStatus($cron_name = 'data')
    {
        self::writeCron([
            self::CRON_STATUS_NAME => 0,
            self::CRON_IS_RUNNING => 0,
        ], $cron_name);
    }

    
    /**
     * 记录进程的时钟周期的时间
     *
     * @param string $cron_name 进程名称
     * @return void
     */
    public static function running($cron_name = 'data')
    {
        self::writeCron([
            self::CRON_TRACED_AT_NAME => time(),
            self::CRON_IS_RUNNING => 1,
        ], $cron_name);
    }
    
    /**
     * 每分钟
     * @param int $minutes 分钟
     * return string
     */
    public static function everyMinutes($minutes = null){
        if($minutes && is_numeric($minutes)) {
            return '*/'.$minutes.' * * * *';
        }
        return '* * * * *';
    }
    
    /**
     *  每小时
     * @param int $hours 小时
     * return string
     */
    public static function everyHours($hours=1) {
        
        if(is_string($hours)) {
            $hours = intval($hours);
        }
        
        if(empty($hours)) {
            $hours = 1;
        }
        return '* */'.$hours.' * * *';
        
    }
}

