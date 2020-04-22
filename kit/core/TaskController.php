<?php

namespace app\kit\core;

use Yii;
use app\kit\models\Cron;
use app\kit\helpers\KitHelper;
use yii\web\Controller;

/**
 * 定时任务的基类
 *
 * @author dungang
 */
abstract class TaskController extends Controller
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
     * 执行任务的方法
     *
     * @param array $param 定时任务配置的参数
     * @param Cron $task 当前任务实例对象
     */
    protected abstract function execJob($param, $task);

    /**
     * 默认的action 不可以修改和覆写
     *
     * @param string $id
     *            任务id
     * @param string $token
     *            任务密钥
     * @return string
     */
    public final function actionIndex($id, $token)
    {
        Yii::trace('Validating One Task : ' . $id, __METHOD__);
        if ($cron = Cron::findOne([
            'id' => $id
        ])) {
            if (KitHelper::isDevMode() || $cron->token == $token) {
                try {
                    $this->execJob(KitHelper::parseText2Assoc($cron->param), $cron);
                } catch (\Exception $e) {
                    Yii::warning('定时任务执行异常：' . $cron->task . ',' . $e->getMessage(), __METHOD__);
                    Yii::warning($e->getTraceAsString(), __METHOD__);
                    $cron->is_ok = false;
                    $cron->error_msg = $e->getMessage();
                }
                //放在任务程序的后面，方便调试。
                $cron->token = \Yii::$app->security->generateRandomString(32);
                KitHelper::isDevMode() || $cron->save(false);
            }
        }
        return '';
    }
}
