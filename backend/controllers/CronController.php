<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\CrontabHelper;

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
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\CronSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Cron'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Cron'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Cron'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Cron'
                ]
            ],
            'run' => [
                'class' => '\DuAdmin\Core\LoopAction',
                'beforeRunCallback' => [
                    $this,
                    'canStartCronProcess'
                ],
                'debug' => false,
                'longPollingHandlerClass' => '\app\backend\Components\CronHandler'
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
