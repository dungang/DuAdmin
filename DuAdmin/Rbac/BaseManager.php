<?php

namespace DuAdmin\Rbac;

use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\rbac\ManagerInterface;

/**
 * BaseManager is a base class implementing [[ManagerInterface]] for RBAC management.
 *
 * For more details and usage information on DbManager, see the [Guide article on security authorization](Guide:security-authorization).
 *
 * @property-read Role[] $defaultRoleInstances Default roles. The array is indexed by the role names. This
 * property is read-only.
 * @property string[] $defaultRoles Default roles. Note that the type of this property differs in getter and
 * setter. See [[getDefaultRoles()]]  and [[setDefaultRoles()]] for details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
abstract class BaseManager extends Component implements ManagerInterface
{
    /**
     * @var array a list of role ids that are assigned to every user automatically without calling [[assign()]].
     * Note that these roles are applied to users, regardless of their state of authentication.
     */
    protected $defaultRoles = [];


    /**
     * Returns the idd auth item.
     * @param string $id the auth item id.
     * @return Item the auth item corresponding to the specified id. Null is returned if no such item.
     */
    abstract protected function getItem($id);

    /**
     * Returns the items of the specified type.
     * @param int $type the auth item type (either [[Item::TYPE_ROLE]] or [[Item::TYPE_PERMISSION]]
     * @return Item[] the auth items of the specified type.
     */
    abstract protected function getItems($type);

    /**
     * Adds an auth item to the RBAC system.
     * @param Item $item the item to add
     * @return bool whether the auth item is successfully added to the system
     * @throws \Exception if data validation or saving fails (such as the id of the role or permission is not unique)
     */
    abstract protected function addItem($item);

    /**
     * Adds a rule to the RBAC system.
     * @param Rule $rule the rule to add
     * @return bool whether the rule is successfully added to the system
     * @throws \Exception if data validation or saving fails (such as the id of the rule is not unique)
     */
    abstract protected function addRule($rule);

    /**
     * Removes an auth item from the RBAC system.
     * @param Item $item the item to remove
     * @return bool whether the role or permission is successfully removed
     * @throws \Exception if data validation or saving fails (such as the id of the role or permission is not unique)
     */
    abstract protected function removeItem($item);

    /**
     * Removes a rule from the RBAC system.
     * @param Rule $rule the rule to remove
     * @return bool whether the rule is successfully removed
     * @throws \Exception if data validation or saving fails (such as the id of the rule is not unique)
     */
    abstract protected function removeRule($rule);

    /**
     * Updates an auth item in the RBAC system.
     * @param string $id the id of the item being updated
     * @param Item $item the updated item
     * @return bool whether the auth item is successfully updated
     * @throws \Exception if data validation or saving fails (such as the id of the role or permission is not unique)
     */
    abstract protected function updateItem($id, $item);

    /**
     * Updates a rule to the RBAC system.
     * @param string $id the id of the rule being updated
     * @param Rule $rule the updated rule
     * @return bool whether the rule is successfully updated
     * @throws \Exception if data validation or saving fails (such as the id of the rule is not unique)
     */
    abstract protected function updateRule($id, $rule);

    /**
     * {@inheritdoc}
     */
    public function createRole($id)
    {
        $role = new Role();
        $role->id = $id;
        return $role;
    }

    /**
     * {@inheritdoc}
     */
    public function createPermission($id)
    {
        $permission = new Permission();
        $permission->id = $id;
        return $permission;
    }

    /**
     * {@inheritdoc}
     */
    public function add($object)
    {
        if ($object instanceof Item) {
            if ($object->ruleId && $this->getRule($object->ruleId) === null) {
                $rule = \Yii::createObject($object->ruleId);
                $rule->id = $object->ruleId;
                $this->addRule($rule);
            }

            return $this->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->addRule($object);
        }

        throw new InvalidArgumentException('Adding unsupported object type.');
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object)
    {
        if ($object instanceof Item) {
            return $this->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->removeRule($object);
        }

        throw new InvalidArgumentException('Removing unsupported object type.');
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $object)
    {
        if ($object instanceof Item) {
            if ($object->ruleId && $this->getRule($object->ruleId) === null) {
                $rule = \Yii::createObject($object->ruleId);
                $rule->id = $object->ruleId;
                $this->addRule($rule);
            }

            return $this->updateItem($id, $object);
        } elseif ($object instanceof Rule) {
            return $this->updateRule($id, $object);
        }

        throw new InvalidArgumentException('Updating unsupported object type.');
    }

    /**
     * {@inheritdoc}
     */
    public function getRole($id)
    {
        $item = $this->getItem($id);
        return $item instanceof Item && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermission($id)
    {
        $item = $this->getItem($id);
        return $item instanceof Item && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->getItems(Item::TYPE_ROLE);
    }

    /**
     * Set default roles
     * @param string[]|\Closure $roles either array of roles or a callable returning it
     * @throws InvalidArgumentException when $roles is neither array nor Closure
     * @throws InvalidValueException when Closure return is not an array
     * @since 2.0.14
     */
    public function setDefaultRoles($roles)
    {
        if (is_array($roles)) {
            $this->defaultRoles = $roles;
        } elseif ($roles instanceof \Closure) {
            $roles = call_user_func($roles);
            if (!is_array($roles)) {
                throw new InvalidValueException('Default roles closure must return an array');
            }
            $this->defaultRoles = $roles;
        } else {
            throw new InvalidArgumentException('Default roles must be either an array or a callable');
        }
    }

    /**
     * Get default roles
     * @return string[] default roles
     * @since 2.0.14
     */
    public function getDefaultRoles()
    {
        return $this->defaultRoles;
    }

    /**
     * Returns defaultRoles as array of Role objects.
     * @since 2.0.12
     * @return Role[] default roles. The array is indexed by the role ids
     */
    public function getDefaultRoleInstances()
    {
        $result = [];
        foreach ($this->defaultRoles as $roleId) {
            $result[$roleId] = $this->createRole($roleId);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->getItems(Item::TYPE_PERMISSION);
    }

    /**
     * Executes the rule associated with the specified auth item.
     *
     * If the item does not specify a rule, this method will return true. Otherwise, it will
     * return the value of [[Rule::execute()]].
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the auth item that needs to execute its rule
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]] and will be passed to the rule
     * @return bool the return value of [[Rule::execute()]]. If the auth item does not specify a rule, true will be returned.
     * @throws InvalidConfigException if the auth item has an invalid rule.
     */
    protected function executeRule($user, $item, $params)
    {
        if ($item->ruleId === null) {
            return true;
        }
        $rule = $this->getRule($item->ruleId);
        if ($rule instanceof Rule) {
            return $rule->execute($user, $item, $params);
        }

        throw new InvalidConfigException("Rule not found: {$item->ruleId}");
    }

    /**
     * Checks whether array of $assignments is empty and [[defaultRoles]] property is empty as well.
     *
     * @param Assignment[] $assignments array of user's assignments
     * @return bool whether array of $assignments is empty and [[defaultRoles]] property is empty as well
     * @since 2.0.11
     */
    protected function hasNoAssignments(array $assignments)
    {
        return empty($assignments) && empty($this->defaultRoles);
    }
}
