<?php
namespace DuAdmin\Components;

use yii\base\BaseObject;
use yii\web\ErrorAction;
use DuAdmin\Core\LongPollAction;
use DuAdmin\Core\LoopAction;
use yii\helpers\Json;

/**
 * 操作日志组件
 * 在config/web.php的组件项目中配置才生效
 * 不配置不生效
 * @author dungang<dungang@126.com>
 * @since 2020-12-24
 */
class ActionLog extends BaseObject
{

    /**
     * 日子表名
     * @var string
     */
    public $tableName = "{{%action_log}}";

    public function recordLog()
    {
        $action = \Yii::$app->requestedAction;
        if ($this->canRecord($action)) {
            if (! \Yii::$app->user->isGuest) {
                $data = $_REQUEST;
                unset($data['r'], $data['_csrf']);
                \Yii::$app->db->createCommand()
                    ->insert($this->tableName, [
                    'userId' => \Yii::$app->user->id,
                    'action' => $action->getUniqueId(),
                    'ip' => ip2long(\Yii::$app->request->getRemoteIP()),
                    'method' => strtoupper(\Yii::$app->request->method),
                    'sourceType' => \Yii::$app->mode,
                    'data' => Json::encode($data)
                ])
                    ->execute();
            }
        }
    }

    private function canRecord($action)
    {
        if ($action instanceof ErrorAction) {
            return false;
        } else if ($action instanceof LongPollAction) {
            return false;
        } else if ($action instanceof LoopAction) {
            return false;
        }
        return true;
    }
}

