<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\backend\helpers\CrontabHelpers;

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
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\CronSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Cron'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Cron'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Cron'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Cron'
                ]
            ],
            'run' => [
                'class' => '\app\kit\core\LoopAction',
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
        if (CrontabHelpers::getCronStatus()) {
            CrontabHelpers::unactiveCronStatus();
        } else {
            CrontabHelpers::activeCronStatus();
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
        list ($status, $traced_at) = CrontabHelpers::prepareCronSetting();
        if ($status > 1) {
            CrontabHelpers::tracedCron();
            //表示没有cron进程在运行，需要重新启动，如果超过1800秒【半小时】没更新时间，也重新启动
            if (empty($traced_at) || intval($traced_at) + 1800 < time()) {
                return true;
            }
        }
        return false;
    }
}
