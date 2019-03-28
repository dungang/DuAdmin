<?php
namespace app\kit\core;

use yii\rbac\DbManager;
use app\kit\helpers\KitHelper;
use yii\rbac\Assignment;

class CoreAuthManager extends DbManager
{

    /**
     *
     * {@inheritdoc}
     * @see \yii\rbac\DbManager::getAssignments()
     */
    public function getAssignments($userId)
    {
        $assignments = parent::getAssignments($userId);
        if (($project = $project = KitHelper::getProject()) && isset($project['position'])) {
            $assignments[$project['position']] = new Assignment([
                'userId' => $userId,
                'roleName' => $project['position']
            ]);
        }
        return $assignments;
    }
}

