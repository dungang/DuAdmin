<?php
namespace app\backend\helpers;

/**
 *
 * @author dungang
 */
class CrontabHelpers
{

    const CRON_STATUS_NAME = 'crontab.status';

    const CRON_TRACED_AT_NAME = 'crontab.traced_at';

    public static function prepareCronSetting()
    {
        $status = \Yii::$app->cache->getOrSet(self::CRON_STATUS_NAME, function () {
            return 0;
        });
        $traced_at = \Yii::$app->cache->getOrSet(self::CRON_TRACED_AT_NAME, function () {
            return 0;
        });

        return [
            $status,
            $traced_at
        ];
    }

    public static function getCronStatus()
    {
        return \Yii::$app->cache->getOrSet(self::CRON_STATUS_NAME, 0);
    }

    public static function activeCronStatus()
    {
        \Yii::$app->cache->set(self::CRON_STATUS_NAME, time());
    }

    public static function unactiveCronStatus()
    {
        \Yii::$app->cache->set(self::CRON_STATUS_NAME, 0);
    }

    public static function tracedCron()
    {
        \Yii::$app->cache->set(self::CRON_TRACED_AT_NAME, time());
    }
}

