<?php
namespace app\backend\helpers;

use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 *
 * @author dungang
 */
class CrontabHelpers
{

    const CRON_STATUS_NAME = 'crontab.status';

    const CRON_TRACED_AT_NAME = 'crontab.traced_at';

    const CRON_DATA_FILE = '@runtime/cron/data.txt';

    private static function readCron()
    {
        $file = \Yii::getAlias(self::CRON_DATA_FILE);
        if (! \is_file($file)) {
            $dir = \dirname($file);
            if (! \is_dir($dir)) {
                FileHelper::createDirectory($dir);
            }
            \file_put_contents($file, Json::encode([
                self::CRON_STATUS_NAME => 0,
                self::CRON_TRACED_AT_NAME => 0
            ]));
        }
        if ($data = \file_get_contents($file)) {
            return Json::decode($data);
        }
        return [
            self::CRON_STATUS_NAME => 0,
            self::CRON_TRACED_AT_NAME => 0
        ];
    }

    private static function writeCron($data)
    {
        $raw = self::readCron();
        $file = \Yii::getAlias(self::CRON_DATA_FILE);
        \file_put_contents($file, Json::encode(\array_merge($raw, $data)));
    }

    public static function prepareCronSetting()
    {
        $data = self::readCron();

        return [
            $data[self::CRON_STATUS_NAME],
            $data[self::CRON_TRACED_AT_NAME]
        ];
    }

    public static function getCronStatus()
    {
        return self::readCron()[self::CRON_STATUS_NAME];
    }

    public static function activeCronStatus()
    {
        self::writeCron([
            self::CRON_STATUS_NAME => time()
        ]);
    }

    public static function unactiveCronStatus()
    {
        self::writeCron([
            self::CRON_STATUS_NAME => 0
        ]);
    }

    public static function tracedCron()
    {
        self::writeCron([
            self::CRON_TRACED_AT_NAME => time()
        ]);
    }
}

