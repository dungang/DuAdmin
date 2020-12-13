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
                    'class' => 'DuAdmin\Models\Cron'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Cron'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Cron'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Cron'
                ]
            ],
            'run' => [
                'class' => '\DuAdmin\Core\LoopAction',
                'beforeRunCallback' => [
                    $this,
                    'canStartCronProcess'
                ],
                'longPollingHandlerClass' => '\Backend\Components\CronHandler'
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
        list ($status, $tracedAt, $isRunning) = CrontabHelper::prepareCronSetting();
        if ($status > 1) {
            // 表示没有cron进程在运行，需要重新启动，如果超过1800秒【半小时】没更新时间，也重新启动
            if (YII_DEBUG || $isRunning === 0 || intval($tracedAt) + 1800 < time()) {
                CrontabHelper::running();
                return true;
            }
        }
        return false;
    }
}
