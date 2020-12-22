<?php
namespace DuAdmin\Rbac;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidCallException;
use yii\caching\CacheInterface;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\di\Instance;
use yii\caching\Cache;

/**
 * DbManager represents an authorization manager that stores authorization information in database.
 *
 * The database connection is specified by [[db]]. The database schema could be initialized by applying migration:
 *
 * ```
 * yii migrate --migrationPath=@yii/rbac/migrations/
 * ```
 *
 * If you don't want to use migration and need SQL instead, files for all databases are in migrations directory.
 *
 * You may change the ids of the tables used to store the authorization and rule data by setting [[itemTable]],
 * [[itemChildTable]], [[assignmentTable]] and [[ruleTable]].
 *
 * For more details and usage information on DbManager, see the [guide article on security authorization](guide:security-authorization).
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class DbManager extends BaseManager
{

    /**
     *
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     *      After the DbManager object is created, if you want to change this property, you should only assign it
     *      with a DB connection object.
     *      Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';

    /**
     *
     * @var string the id of the table storing authorization items. Defaults to "auth_item".
     */
    public $itemTable = '{{%auth_item}}';

    /**
     *
     * @var string the id of the table storing authorization item hierarchy. Defaults to "auth_item_child".
     */
    public $itemChildTable = '{{%auth_item_child}}';

    /**
     *
     * @var string the id of the table storing authorization item assignments. Defaults to "auth_assignment".
     */
    public $assignmentTable = '{{%auth_assignment}}';

    /**
     *
     * @var string the id of the table storing rules. Defaults to "auth_rule".
     */
    public $ruleTable = '{{%auth_rule}}';

    /**
     *
     * @var CacheInterface|array|string the cache used to improve RBAC performance. This can be one of the following:
     *     
     *      - an application component ID (e.g. `cache`)
     *      - a configuration array
     *      - a [[\yii\caching\Cache]] object
     *     
     *      When this is not set, it means caching is not enabled.
     *     
     *      Note that by enabling RBAC cache, all auth items, rules and auth item parent-child relationships will
     *      be cached and loaded into memory. This will improve the performance of RBAC permission check. However,
     *      it does require extra memory and as a result may not be appropriate if your RBAC system contains too many
     *      auth items. You should seek other RBAC implementations (e.g. RBAC based on Redis storage) in this case.
     *     
     *      Also note that if you modify RBAC items, rules or parent-child relationships from outside of this component,
     *      you have to manually call [[invalidateCache()]] to ensure data consistency.
     *     
     * @since 2.0.3
     */
    public $cache;

    /**
     *
     * @var string the key used to store RBAC data in cache
     * @see Cache
     * @since 2.0.3
     */
    public $cacheKey = 'rbac';

    /**
     *
     * @var Item[] all auth items (id => Item)
     */
    protected $items;

    /**
     *
     * @var Rule[] all auth rules (id => Rule)
     */
    protected $rules;

    /**
     *
     * @var array auth item parent-child relationships (childid => list of parents)
     */
    protected $parents;

    /**
     *
     * @var array user assignments (user id => Assignment[])
     * @since `protected` since 2.0.38
     */
    protected $checkAccessAssignments = [];

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by establishing the database connection.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, 'yii\caching\CacheInterface');
        }
    }

    /**
     * 验证用户的权限，补执行规则
     * @param number $userId
     * @param string $permissionId
     * @param array $params
     * @return boolean
     */
    public function checkAccessWithoutRule($userId, $permissionId, $params = [])
    {
        if (isset($this->checkAccessAssignments[(string) $userId])) {
            $assignments = $this->checkAccessAssignments[(string) $userId];
        } else {
            $assignments = $this->getAssignments($userId);
            $this->checkAccessAssignments[(string) $userId] = $assignments;
        }

        if ($this->hasNoAssignments($assignments)) {
            return false;
        }

        $this->loadFromCache();
        if ($this->items !== null) {
            return $this->checkAccessFromCache($userId, $permissionId, $params, $assignments, false);
        }

        return $this->checkAccessRecursive($userId, $permissionId, $params, $assignments, false);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function checkAccess($userId, $permissionId, $params = [])
    {
        if (isset($this->checkAccessAssignments[(string) $userId])) {
            $assignments = $this->checkAccessAssignments[(string) $userId];
        } else {
            $assignments = $this->getAssignments($userId);
            $this->checkAccessAssignments[(string) $userId] = $assignments;
        }

        if ($this->hasNoAssignments($assignments)) {
            return false;
        }

        $this->loadFromCache();
        if ($this->items !== null) {
            return $this->checkAccessFromCache($userId, $permissionId, $params, $assignments);
        }

        return $this->checkAccessRecursive($userId, $permissionId, $params, $assignments);
    }

    /**
     * Performs access check for the specified user based on the data loaded from cache.
     * This method is internally called by [[checkAccess()]] when [[cache]] is enabled.
     *
     * @param string|int $user
     *            the user ID. This should can be either an integer or a string representing
     *            the unique identifier of a user. See [[\yii\web\User::id]].
     * @param string $itemId
     *            the id of the operation that need access check
     * @param array $params
     *            id-value pairs that would be passed to rules associated
     *            with the tasks and roles assigned to the user. A param with id 'user' is added to this array,
     *            which holds the value of `$userId`.
     * @param Assignment[] $assignments
     *            the assignments to the specified user
     * @param bool $validateRule
     * @return bool whether the operations can be performed by the user.
     * @since 2.0.3
     */
    protected function checkAccessFromCache($user, $itemId, $params, $assignments, $validateRule = true)
    {
        if (! isset($this->items[$itemId])) {
            return false;
        }

        $item = $this->items[$itemId];

        Yii::debug($item instanceof Role ? "Checking role: $itemId" : "Checking permission: $itemId", __METHOD__);

        if ($validateRule) {
            if (! $this->executeRule($user, $item, $params)) {
                return false;
            }
        }

        if (isset($assignments[$itemId]) || in_array($itemId, $this->defaultRoles)) {
            return true;
        }

        if (! empty($this->parents[$itemId])) {
            foreach ($this->parents[$itemId] as $parent) {
                if ($this->checkAccessFromCache($user, $parent, $params, $assignments)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Performs access check for the specified user.
     * This method is internally called by [[checkAccess()]].
     *
     * @param string|int $user
     *            the user ID. This should can be either an integer or a string representing
     *            the unique identifier of a user. See [[\yii\web\User::id]].
     * @param string $itemId
     *            the id of the operation that need access check
     * @param array $params
     *            id-value pairs that would be passed to rules associated
     *            with the tasks and roles assigned to the user. A param with id 'user' is added to this array,
     *            which holds the value of `$userId`.
     * @param Assignment[] $assignments
     *            the assignments to the specified user
     * @param bool $validateRule
     * @return bool whether the operations can be performed by the user.
     */
    protected function checkAccessRecursive($user, $itemId, $params, $assignments, $validateRule = true)
    {
        if (($item = $this->getItem($itemId)) === null) {
            return false;
        }

        Yii::debug($item instanceof Role ? "Checking role: $itemId" : "Checking permission: $itemId", __METHOD__);

        if ($validateRule) {
            if (! $this->executeRule($user, $item, $params)) {
                return false;
            }
        }

        if (isset($assignments[$itemId]) || in_array($itemId, $this->defaultRoles)) {
            return true;
        }

        $query = new Query();
        $parents = $query->select([
            'parent'
        ])
            ->from($this->itemChildTable)
            ->where([
            'child' => $itemId
        ])
            ->column($this->db);
        foreach ($parents as $parent) {
            if ($this->checkAccessRecursive($user, $parent, $params, $assignments)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getItem($id)
    {
        if (empty($id)) {
            return null;
        }

        if (! empty($this->items[$id])) {
            return $this->items[$id];
        }

        $row = (new Query())->from($this->itemTable)
            ->where([
            'id' => $id
        ])
            ->one($this->db);

        if ($row === false) {
            return null;
        }

        return $this->populateItem($row);
    }

    /**
     * Returns a value indicating whether the database supports cascading update and delete.
     * The default implementation will return false for SQLite database and true for all other databases.
     *
     * @return bool whether the database supports cascading update and delete.
     */
    protected function supportsCascadeUpdate()
    {
        return strncmp($this->db->getDriverName(), 'sqlite', 6) !== 0;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function addItem($item)
    {
        $time = date('Y-m-d H:i:s');
        if ($item->createdAt === null) {
            $item->createdAt = $time;
        }
        if ($item->updatedAt === null) {
            $item->updatedAt = $time;
        }
        $this->db->createCommand()
            ->insert($this->itemTable, [
            'id' => $item->id,
            'type' => $item->type,
            'name' => $item->name,
            'ruleId' => $item->ruleId,
            'data' => $item->data === null ? null : serialize($item->data),
            'createdAt' => $item->createdAt,
            'updatedAt' => $item->updatedAt
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function removeItem($item)
    {
        if (! $this->supportsCascadeUpdate()) {
            $this->db->createCommand()
                ->delete($this->itemChildTable, [
                'or',
                '[[parent]]=:parent',
                '[[child]]=:child'
            ], [
                ':parent' => $item->id,
                ':child' => $item->id
            ])
                ->execute();
            $this->db->createCommand()
                ->delete($this->assignmentTable, [
                'itemId' => $item->id
            ])
                ->execute();
        }

        $this->db->createCommand()
            ->delete($this->itemTable, [
            'id' => $item->id
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function updateItem($id, $item)
    {
        if ($item->id !== $id && ! $this->supportsCascadeUpdate()) {
            $this->db->createCommand()
                ->update($this->itemChildTable, [
                'parent' => $item->id
            ], [
                'parent' => $id
            ])
                ->execute();
            $this->db->createCommand()
                ->update($this->itemChildTable, [
                'child' => $item->id
            ], [
                'child' => $id
            ])
                ->execute();
            $this->db->createCommand()
                ->update($this->assignmentTable, [
                'itemId' => $item->id
            ], [
                'itemId' => $id
            ])
                ->execute();
        }

        $item->updatedAt = time();

        $this->db->createCommand()
            ->update($this->itemTable, [
            'id' => $item->id,
            'name' => $item->name,
            'ruleId' => $item->ruleId,
            'data' => $item->data === null ? null : serialize($item->data),
            'updatedAt' => $item->updatedAt
        ], [
            'id' => $id
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function addRule($rule)
    {
        $time = time();
        if ($rule->createdAt === null) {
            $rule->createdAt = $time;
        }
        if ($rule->updatedAt === null) {
            $rule->updatedAt = $time;
        }
        $this->db->createCommand()
            ->insert($this->ruleTable, [
            'id' => $rule->id,
            'name' => $rule->name,
            'data' => serialize($rule),
            'createdAt' => $rule->createdAt,
            'updatedAt' => $rule->updatedAt
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function updateRule($id, $rule)
    {
        if ($rule->id !== $id && ! $this->supportsCascadeUpdate()) {
            $this->db->createCommand()
                ->update($this->itemTable, [
                'ruleId' => $rule->id
            ], [
                'ruleId' => $id
            ])
                ->execute();
        }

        $rule->updatedAt = time();

        $this->db->createCommand()
            ->update($this->ruleTable, [
            'id' => $rule->id,
            'data' => serialize($rule),
            'updatedAt' => $rule->updatedAt
        ], [
            'id' => $id
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function removeRule($rule)
    {
        if (! $this->supportsCascadeUpdate()) {
            $this->db->createCommand()
                ->update($this->itemTable, [
                'ruleId' => null
            ], [
                'ruleId' => $rule->id
            ])
                ->execute();
        }

        $this->db->createCommand()
            ->delete($this->ruleTable, [
            'id' => $rule->id
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getItems($type)
    {
        $query = (new Query())->from($this->itemTable)->where([
            'type' => $type
        ]);

        $items = [];
        foreach ($query->all($this->db) as $row) {
            $items[$row['id']] = $this->populateItem($row);
        }

        return $items;
    }

    /**
     * Populates an auth item with the data fetched from database.
     *
     * @param array $row
     *            the data from the auth item table
     * @return Item the populated auth item instance (either Role or Permission)
     */
    protected function populateItem($row)
    {
        $class = $row['type'] == Item::TYPE_PERMISSION ? Permission::class : Role::class;

        if (! isset($row['data']) || ($data = @unserialize(is_resource($row['data']) ? stream_get_contents($row['data']) : $row['data'])) === false) {
            $data = null;
        }

        return new $class([
            'id' => $row['id'],
            'type' => $row['type'],
            'name' => $row['name'],
            'ruleId' => $row['ruleId'] ?: null,
            'data' => $data,
            'createdAt' => $row['createdAt'],
            'updatedAt' => $row['updatedAt']
        ]);
    }

    /**
     *
     * {@inheritdoc} The roles returned by this method include the roles assigned via [[$defaultRoles]].
     */
    public function getRolesByUser($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return [];
        }

        $query = (new Query())->select('b.*')
            ->from([
            'a' => $this->assignmentTable,
            'b' => $this->itemTable
        ])
            ->where('{{a}}.[[itemId]]={{b}}.[[id]]')
            ->andWhere([
            'a.userId' => (string) $userId
        ])
            ->andWhere([
            'b.type' => Item::TYPE_ROLE
        ]);

        $roles = $this->getDefaultRoleInstances();
        foreach ($query->all($this->db) as $row) {
            $roles[$row['id']] = $this->populateItem($row);
        }

        return $roles;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getChildRoles($roleid)
    {
        $role = $this->getRole($roleid);

        if ($role === null) {
            throw new InvalidArgumentException("Role \"$roleid\" not found.");
        }

        $result = [];
        $this->getChildrenRecursive($roleid, $this->getChildrenList(), $result);

        $roles = [
            $roleid => $role
        ];

        $roles += array_filter($this->getRoles(), function (Role $roleItem) use ($result) {
            return array_key_exists($roleItem->id, $result);
        });

        return $roles;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getPermissionsByRole($roleid)
    {
        $childrenList = $this->getChildrenList();
        $result = [];
        $this->getChildrenRecursive($roleid, $childrenList, $result);
        if (empty($result)) {
            return [];
        }
        $query = (new Query())->from($this->itemTable)->where([
            'type' => Item::TYPE_PERMISSION,
            'id' => array_keys($result)
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['id']] = $this->populateItem($row);
        }

        return $permissions;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getPermissionsByUser($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return [];
        }

        $directPermission = $this->getDirectPermissionsByUser($userId);
        $inheritedPermission = $this->getInheritedPermissionsByUser($userId);

        return array_merge($directPermission, $inheritedPermission);
    }

    /**
     * Returns all permissions that are directly assigned to user.
     *
     * @param string|int $userId
     *            the user ID (see [[\yii\web\User::id]])
     * @return Permission[] all direct permissions that the user has. The array is indexed by the permission ids.
     * @since 2.0.7
     */
    protected function getDirectPermissionsByUser($userId)
    {
        $query = (new Query())->select('b.*')
            ->from([
            'a' => $this->assignmentTable,
            'b' => $this->itemTable
        ])
            ->where('{{a}}.[[itemId]]={{b}}.[[id]]')
            ->andWhere([
            'a.userId' => (string) $userId
        ])
            ->andWhere([
            'b.type' => Item::TYPE_PERMISSION
        ]);

        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['id']] = $this->populateItem($row);
        }

        return $permissions;
    }

    /**
     * Returns all permissions that the user inherits from the roles assigned to him.
     *
     * @param string|int $userId
     *            the user ID (see [[\yii\web\User::id]])
     * @return Permission[] all inherited permissions that the user has. The array is indexed by the permission ids.
     * @since 2.0.7
     */
    protected function getInheritedPermissionsByUser($userId)
    {
        $query = (new Query())->select('itemId')
            ->from($this->assignmentTable)
            ->where([
            'userId' => (string) $userId
        ]);

        $childrenList = $this->getChildrenList();
        $result = [];
        foreach ($query->column($this->db) as $roleid) {
            $this->getChildrenRecursive($roleid, $childrenList, $result);
        }

        if (empty($result)) {
            return [];
        }

        $query = (new Query())->from($this->itemTable)->where([
            'type' => Item::TYPE_PERMISSION,
            'id' => array_keys($result)
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['id']] = $this->populateItem($row);
        }

        return $permissions;
    }

    /**
     * Returns the children for every parent.
     *
     * @return array the children list. Each array key is a parent item id,
     *         and the corresponding array value is a list of child item ids.
     */
    protected function getChildrenList()
    {
        $query = (new Query())->from($this->itemChildTable);
        $parents = [];
        foreach ($query->all($this->db) as $row) {
            $parents[$row['parent']][] = $row['child'];
        }

        return $parents;
    }

    /**
     * Recursively finds all children and grand children of the specified item.
     *
     * @param string $id
     *            the id of the item whose children are to be looked for.
     * @param array $childrenList
     *            the child list built via [[getChildrenList()]]
     * @param array $result
     *            the children and grand children (in array keys)
     */
    protected function getChildrenRecursive($id, $childrenList, &$result)
    {
        if (isset($childrenList[$id])) {
            foreach ($childrenList[$id] as $child) {
                $result[$child] = true;
                $this->getChildrenRecursive($child, $childrenList, $result);
            }
        }
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getRule($id)
    {
        if ($this->rules !== null) {
            return isset($this->rules[$id]) ? $this->rules[$id] : null;
        }

        $row = (new Query())->select([
            'data'
        ])
            ->from($this->ruleTable)
            ->where([
            'id' => $id
        ])
            ->one($this->db);
        if ($row === false) {
            return null;
        }
        $data = $row['data'];
        if (is_resource($data)) {
            $data = stream_get_contents($data);
        }

        return unserialize($data);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getRules()
    {
        if ($this->rules !== null) {
            return $this->rules;
        }

        $query = (new Query())->from($this->ruleTable);

        $rules = [];
        foreach ($query->all($this->db) as $row) {
            $data = $row['data'];
            if (is_resource($data)) {
                $data = stream_get_contents($data);
            }
            $rules[$row['id']] = unserialize($data);
        }

        return $rules;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getAssignment($roleid, $userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return null;
        }

        $row = (new Query())->from($this->assignmentTable)
            ->where([
            'userId' => (string) $userId,
            'itemId' => $roleid
        ])
            ->one($this->db);

        if ($row === false) {
            return null;
        }

        return new Assignment([
            'userId' => $row['userId'],
            'roleid' => $row['itemId'],
            'createdAt' => $row['createdAt']
        ]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getAssignments($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return [];
        }

        $query = (new Query())->from($this->assignmentTable)->where([
            'userId' => (string) $userId
        ]);

        $assignments = [];
        foreach ($query->all($this->db) as $row) {
            $assignments[$row['itemId']] = new Assignment([
                'userId' => $row['userId'],
                'roleid' => $row['itemId'],
                'createdAt' => $row['createdAt']
            ]);
        }

        return $assignments;
    }

    /**
     *
     * {@inheritdoc}
     * @since 2.0.8
     */
    public function canAddChild($parent, $child)
    {
        return ! $this->detectLoop($parent, $child);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function addChild($parent, $child)
    {
        if ($parent->id === $child->id) {
            throw new InvalidArgumentException("Cannot add '{$parent->id}' as a child of itself.");
        }

        if ($parent instanceof Permission && $child instanceof Role) {
            throw new InvalidArgumentException('Cannot add a role as a child of a permission.');
        }

        if ($this->detectLoop($parent, $child)) {
            throw new InvalidCallException("Cannot add '{$child->id}' as a child of '{$parent->id}'. A loop has been detected.");
        }

        $this->db->createCommand()
            ->insert($this->itemChildTable, [
            'parent' => $parent->id,
            'child' => $child->id
        ])
            ->execute();

        $this->invalidateCache();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeChild($parent, $child)
    {
        $result = $this->db->createCommand()
            ->delete($this->itemChildTable, [
            'parent' => $parent->id,
            'child' => $child->id
        ])
            ->execute() > 0;

        $this->invalidateCache();

        return $result;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeChildren($parent)
    {
        $result = $this->db->createCommand()
            ->delete($this->itemChildTable, [
            'parent' => $parent->id
        ])
            ->execute() > 0;

        $this->invalidateCache();

        return $result;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function hasChild($parent, $child)
    {
        return (new Query())->from($this->itemChildTable)
            ->where([
            'parent' => $parent->id,
            'child' => $child->id
        ])
            ->one($this->db) !== false;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getChildren($id)
    {
        $query = (new Query())->select([
            'id',
            'type',
            'name',
            'ruleId',
            'data',
            'createdAt',
            'updatedAt'
        ])
            ->from([
            $this->itemTable,
            $this->itemChildTable
        ])
            ->where([
            'parent' => $id,
            'id' => new Expression('[[child]]')
        ]);

        $children = [];
        foreach ($query->all($this->db) as $row) {
            $children[$row['id']] = $this->populateItem($row);
        }

        return $children;
    }

    /**
     * Checks whether there is a loop in the authorization item hierarchy.
     *
     * @param Item $parent
     *            the parent item
     * @param Item $child
     *            the child item to be added to the hierarchy
     * @return bool whether a loop exists
     */
    protected function detectLoop($parent, $child)
    {
        if ($child->id === $parent->id) {
            return true;
        }
        foreach ($this->getChildren($child->id) as $grandchild) {
            if ($this->detectLoop($parent, $grandchild)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function assign($role, $userId)
    {
        $assignment = new Assignment([
            'userId' => $userId,
            'roleid' => $role->id,
            'createdAt' => time()
        ]);

        $this->db->createCommand()
            ->insert($this->assignmentTable, [
            'userId' => $assignment->userId,
            'itemId' => $assignment->roleid,
            'createdAt' => $assignment->createdAt
        ])
            ->execute();

        unset($this->checkAccessAssignments[(string) $userId]);
        return $assignment;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function revoke($role, $userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }

        unset($this->checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
            ->delete($this->assignmentTable, [
            'userId' => (string) $userId,
            'itemId' => $role->id
        ])
            ->execute() > 0;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function revokeAll($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }

        unset($this->checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
            ->delete($this->assignmentTable, [
            'userId' => (string) $userId
        ])
            ->execute() > 0;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeAll()
    {
        $this->removeAllAssignments();
        $this->db->createCommand()
            ->delete($this->itemChildTable)
            ->execute();
        $this->db->createCommand()
            ->delete($this->itemTable)
            ->execute();
        $this->db->createCommand()
            ->delete($this->ruleTable)
            ->execute();
        $this->invalidateCache();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeAllPermissions()
    {
        $this->removeAllItems(Item::TYPE_PERMISSION);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeAllRoles()
    {
        $this->removeAllItems(Item::TYPE_ROLE);
    }

    /**
     * Removes all auth items of the specified type.
     *
     * @param int $type
     *            the auth item type (either Item::TYPE_PERMISSION or Item::TYPE_ROLE)
     */
    protected function removeAllItems($type)
    {
        if (! $this->supportsCascadeUpdate()) {
            $ids = (new Query())->select([
                'id'
            ])
                ->from($this->itemTable)
                ->where([
                'type' => $type
            ])
                ->column($this->db);
            if (empty($ids)) {
                return;
            }
            $key = $type == Item::TYPE_PERMISSION ? 'child' : 'parent';
            $this->db->createCommand()
                ->delete($this->itemChildTable, [
                $key => $ids
            ])
                ->execute();
            $this->db->createCommand()
                ->delete($this->assignmentTable, [
                'itemId' => $ids
            ])
                ->execute();
        }
        $this->db->createCommand()
            ->delete($this->itemTable, [
            'type' => $type
        ])
            ->execute();

        $this->invalidateCache();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeAllRules()
    {
        if (! $this->supportsCascadeUpdate()) {
            $this->db->createCommand()
                ->update($this->itemTable, [
                'ruleId' => null
            ])
                ->execute();
        }

        $this->db->createCommand()
            ->delete($this->ruleTable)
            ->execute();

        $this->invalidateCache();
    }

    /**
     *
     * {@inheritdoc}
     */
    public function removeAllAssignments()
    {
        $this->checkAccessAssignments = [];
        $this->db->createCommand()
            ->delete($this->assignmentTable)
            ->execute();
    }

    public function invalidateCache()
    {
        if ($this->cache !== null) {
            $this->cache->delete($this->cacheKey);
            $this->items = null;
            $this->rules = null;
            $this->parents = null;
        }
        $this->checkAccessAssignments = [];
    }

    public function loadFromCache()
    {
        if ($this->items !== null || ! $this->cache instanceof CacheInterface) {
            return;
        }

        $data = $this->cache->get($this->cacheKey);
        if (is_array($data) && isset($data[0], $data[1], $data[2])) {
            list ($this->items, $this->rules, $this->parents) = $data;
            return;
        }

        $query = (new Query())->from($this->itemTable);
        $this->items = [];
        foreach ($query->all($this->db) as $row) {
            $this->items[$row['id']] = $this->populateItem($row);
        }

        $query = (new Query())->from($this->ruleTable);
        $this->rules = [];
        foreach ($query->all($this->db) as $row) {
            $data = $row['data'];
            if (is_resource($data)) {
                $data = stream_get_contents($data);
            }
            $this->rules[$row['id']] = unserialize($data);
        }

        $query = (new Query())->from($this->itemChildTable);
        $this->parents = [];
        foreach ($query->all($this->db) as $row) {
            if (isset($this->items[$row['child']])) {
                $this->parents[$row['child']][] = $row['parent'];
            }
        }

        $this->cache->set($this->cacheKey, [
            $this->items,
            $this->rules,
            $this->parents
        ]);
    }

    /**
     * Returns all role assignment information for the specified role.
     *
     * @param string $roleid
     * @return string[] the ids. An empty array will be
     *         returned if role is not assigned to any user.
     * @since 2.0.7
     */
    public function getUserIdsByRole($roleid)
    {
        if (empty($roleid)) {
            return [];
        }

        return (new Query())->select('[[userId]]')
            ->from($this->assignmentTable)
            ->where([
            'itemId' => $roleid
        ])
            ->column($this->db);
    }

    /**
     * Check whether $userId is empty.
     *
     * @param mixed $userId
     * @return bool
     * @since 2.0.26
     */
    protected function isEmptyUserId($userId)
    {
        return ! isset($userId) || $userId === '';
    }
}
