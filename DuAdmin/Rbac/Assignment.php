<?php


namespace DuAdmin\Rbac;

use yii\base\BaseObject;

class Assignment extends BaseObject
{
    /**
     * @var string|int user ID (see [[\yii\web\User::id]])
     */
    public $userId;
    /**
     * @var string the role id
     */
    public $roleId;
    /**
     * @var string Datetime representing the assignment creation time
     */
    public $createdAt;
}