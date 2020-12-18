<?php
namespace DuAdmin\Rbac;

use yii\base\BaseObject;

abstract class Rule extends BaseObject
{
    /**
     * @var string id of the rule
     */
    public $id;

    public $name;

    public $createdAt;

    public $updatedAt;

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    abstract public function execute($user, $item, $params);
}