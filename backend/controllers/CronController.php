<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\kit\models\Setting;

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
                'class' => 'app\kit\core\LoopAction',
                'beforeRunCallback' => $this->checkCronTabLoop(),
                'debug'=>true,
                'longPollingHandlerClass' => '\app\backend\components\CronHandler'
            ]
        ];
    }

    /**
     * 处理定时器的可执行状态
     * @return callable
     */
    public function checkCronTabLoop()
    {
        return function () {
            if ($trace = Setting::findOne([
                'name' => 'crontab.traced_at'
            ])) {
                if (empty($trace->value) || intval($trace->value) + 180 < time()) {
                    $trace->value = time();
                    $trace->save(false);
                    return true;
                }
            } else {
                //由于Setting默认添加了更新缓存的行为，如果使用模型类来添加，会导致频繁更新缓存。
                \Yii::$app->db->createCommand()
                    ->insert(Setting::tableName(), [
                    'name' => 'crontab.traced_at',
                    'value' => time(),
                    'title' => '定时任务执行时间',
                    'val_type' => 'STR'
                ])
                    ->execute();
                return true;
            }
            return false;
        };
    }
}
