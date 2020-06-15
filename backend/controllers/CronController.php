<?php
namespace app\backend\controllers;

use app\mmadmin\core\BackendController;
use app\mmadmin\helpers\CrontabHelper;

/**
 * CronController implements the CRUD actions for Cron model.
 */
class CronController extends BackendController
{

    public function init()
    {
        parent::init();

        $this->guestActions = [
            'run'
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\CronSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Cron'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Cron'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Cron'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Cron'
                ]
            ],
            'run' => [
                'class' => '\app\mmadmin\core\LoopAction',
                'beforeRunCallback' => [
                    $this,
                    'canStartCronProcess'
                ],
                'debug' => false,
                'longPollingHandlerClass' => '\app\backend\components\CronHandler'
            ]
        ];
    }

    /**
     * 切换定时任务服务状态
     *
     * @return mixed|number[]|string[]
     */
    public function actionSwitchService()
    {
        if (CrontabHelper::getCronStatus()) {
            CrontabHelper::unactiveCronStatus();
        } else {
            CrontabHelper::activeCronStatus();
        }
        return $this->redirectOnSuccess([
            'index'
        ]);
    }

    /**
     * 处理定时器的可执行状态
     *
     * @return callable
     */
    public function canStartCronProcess()
    {
        list ($status, $traced_at) = CrontabHelper::prepareCronSetting();
        if ($status > 1) {
            CrontabHelper::tracedCron();
            //表示没有cron进程在运行，需要重新启动，如果超过1800秒【半小时】没更新时间，也重新启动
            if (empty($traced_at) || intval($traced_at) + 1800 < time()) {
                return true;
            }
        }
        return false;
    }
}
