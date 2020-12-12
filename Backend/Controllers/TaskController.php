<?php

namespace Backend\Controllers;

use Yii;
use Backend\Models\Cron;
use DuAdmin\Helpers\AppHelper;
use yii\web\Controller;

/**
 * 定时任务的基类
 * 直接继承框架的web controller类，可以规避不添加任何的行为和过滤器和权限检查
 *
 * @author dungang
 */
class TaskController extends Controller
{

    public function init()
    {
        parent::init();
        //关闭session
        \Yii::$app->getSession()->close();
        //关闭postCSRF检查
        $this->enableCsrfValidation = false;
        //设置没有超时限制
        set_time_limit(0);
        //忽略用户终端连接
        ignore_user_abort(true);
    }


    /**
     * 默认的action 不可以修改和覆写
     *
     * @param string $id
     *            任务id
     * @param string $token
     *            任务密钥
     * @return string
     */
    public function actionIndex($id, $token)
    {
        Yii::debug('Validating One Task : ' . $id, __METHOD__);
        if ($cron = Cron::findOne([
            'id' => $id
        ])) {
            if (AppHelper::isDevMode() || $cron->token == $token) {
                try {
                    // 执行的任务是存在
                    if (class_exists($cron->job_script)) {
                        $instance = Yii::createObject($cron->job_script);
                        call_user_func([$instance, 'handle'], AppHelper::parseText2Assoc($cron->param), $cron);
                    } else {
                        $cron->is_ok = false;
                        $cron->error_msg = '脚本不存在';
                    }
                } catch (\Exception $e) {
                    Yii::warning('定时任务执行异常：' . $cron->task . ',' . $e->getMessage(), __METHOD__);
                    Yii::warning($e->getTraceAsString(), __METHOD__);
                    $cron->is_ok = false;
                    $cron->error_msg = $e->getMessage();
                }
                //放在任务程序的后面，方便调试。
                $cron->token = \Yii::$app->security->generateRandomString(32);
                AppHelper::isDevMode() || $cron->save(false);
            }
        }
        return '';
    }
}
