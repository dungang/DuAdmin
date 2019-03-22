<?php
namespace app\kit\core;

use Yii;
use app\kit\models\Cron;
use app\kit\helpers\MiscHelper;
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
        set_time_limit(0);
        ignore_user_abort(true);
    }

    /**
     * 执行任务的方法
     *
     * @param array $param
     * @param Cron $task
     */
    protected abstract function execJob($param, $task);

    /**
     * 默认的action
     *
     * @param string $id
     *            任务id
     * @param string $token
     *            任务密钥
     * @return string
     */
    public function actionIndex($id, $token)
    {
        Yii::info('Validating One Task : ' . $id, __METHOD__);
        if ($cron = Cron::findOne([
            'id' => $id,
            'token' => $token
        ])) {
            try {
                $this->execJob(MiscHelper::parseText2Assoc($cron->param), $cron);
            } catch (\Exception $e) {
                Yii::warning('定时任务执行异常：' . $cron->task, __METHOD__);
                $cron->is_ok = false;
            }
            //放在任务程序的后面，方便调试。
            $cron->token = \Yii::$app->security->generateRandomString(32);
            $cron->save(false);
        }
        return '';
    }
}

