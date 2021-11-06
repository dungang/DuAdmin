<?php

namespace DuAdmin\Helpers;

use Backend\Models\AuthAssignment;
use Backend\Models\AuthItem;
use Backend\Models\AuthItemChild;
use Backend\Models\AuthPermission;
use DuAdmin\Models\Cron;
use DuAdmin\Models\DictData;
use DuAdmin\Models\DictType;
use DuAdmin\Models\Menu;
use DuAdmin\Models\Navigation;
use DuAdmin\Models\PrettyUrl;
use DuAdmin\Models\Setting;
use DuAdmin\Mysql\Query;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class InstallerHelper
{

    public static function installAddonPermission($addon, $addonName)
    {
        InstallerHelper::installPermissions([
            [
                'id'       => $addon,
                'name'     => $addonName . '管理'
            ]
        ]);
    }

    /**
     * 第一层的权限去重
     */
    public static function installPermissionCRUDShortcut($name, $routePrefix, $addon)
    {

        InstallerHelper::installPermissions([
            [
                'id' => $addon,
                'children' => [
                    [
                        'id'       => $routePrefix,
                        'name'     => $name . '管理',
                        'children' => [
                            [
                                'id'       => $routePrefix . '/index',
                                'name'     => $name . '列表',
                                'children' => [
                                    [
                                        'id'   => $routePrefix . '/view',
                                        'name' => '查看' . $name
                                    ]
                                ]
                            ],
                            [
                                'id'   => $routePrefix . '/create',
                                'name' => '添加' . $name
                            ],
                            [
                                'id'   => $routePrefix . '/update',
                                'name' => '更新' . $name
                            ],
                            [
                                'id'   => $routePrefix . '/delete',
                                'name' => '删除' . $name
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public static function installPermissions($permissions, $parent = null)
    {

        if ($permissions) {
            foreach ($permissions as $index => $permission) {
                $filter = $permission;
                unset($filter['children']);
                $model = AuthPermission::findOne($filter);
                if (!$model) {
                    $model = new AuthPermission();
                    $model->sort = $index;
                    $model->load($permission, '');
                    $model->save();
                    if ($model->hasErrors()) {
                        throw new ErrorException(Json::encode($model->errors));
                    }
                }
                if ($parent) {
                    $relation = new AuthItemChild();
                    $relation->parent = $parent;
                    $relation->child = $model->id;
                    $relation->sort = $index;
                    $relation->save();
                    if ($relation->hasErrors()) {
                        throw new ErrorException(Json::encode($model->errors));
                    }
                }
                if (isset($permission['children']) && is_array($permission['children'])) {
                    static::installPermissions($permission['children'], $model->id);
                }
            }
        }
    }

    public static function uninstallPermissions($permissionId)
    {
        $childiren = AuthItemChild::find()->select('child')->where(['parent' => $permissionId])->column();
        AuthItem::deleteAll(['id' => $permissionId]);
        AuthAssignment::deleteAll(['itemId' => $permissionId]);
        if ($childiren) {
            AuthItemChild::deleteAll(['parent' => $permissionId]);
            foreach ($childiren as $child) {
                static::uninstallPermissions($child);
            }
        }
        AppHelper::cleanCache(['rbac']);
    }

    public static function InstallDict($dictType, $dictName, $dictData)
    {
        $dict = DictType::findOne(['dictType' => $dictType]);
        if (empty($dict)) {
            $dict = new DictType(['dictType' => $dictType, 'dictName' => $dictName]);
            $dict->status = 1;
            $dict->save(false);
        }
        foreach ($dictData as $data) {
            $data['dictType'] = $dictType;
            $data['status'] = 1;
            $model = new DictData($data);
            $model->updateOrInsert(false, ['dictType' => $dictType, 'dictValue' => $data['dictValue']]);
        }
    }

    public static function UninstallDict($dictType)
    {
        DictData::deleteAll(['dictType' => $dictType]);
        DictType::deleteAll(['dictType' => $dictType]);
    }

    public static function UninstallDictData($dictType, $value)
    {
        DictData::deleteAll(['dictType' => $dictType, 'dictValue' => $value]);
    }

    /**
     * 安装菜单
     *
     * @param array $menus
     * @param number $pid
     * @param string $app
     */
    public static function installMenus($menus, $pid = 0, $app = 'core', $weight = 50)
    {

        if (is_array($menus)) {
            foreach ($menus as $index => $menu) {
                $filter = $menu;
                unset($filter['children']);
                $filter['app'] = $app;
                $model = Menu::findOne($filter);
                if (!$model) {
                    $model = new Menu();
                    $model->load($menu, '');
                    $model->pid = $pid;
                    $model->app = $app;
                    if (isset($menu['sort'])) {
                        $model->sort = $menu['sort'];
                    } else if ($pid === 0) {
                        $model->sort = $weight;
                    } else {
                        $model->sort = $index;
                    }
                    $model->url = trim($model->url, '/');
                    if (!$model->save()) {
                        Yii::error("创建菜单失败：" . $menu['name']);
                        throw new ErrorException("创建菜单失败：" . $menu['name']);
                    }
                    if ($model->hasErrors()) {
                        Yii::error("创建菜单失败：" . Json::encode($model->errors));
                        throw new ErrorException(Json::encode($model->errors));
                    }
                }
                if (isset($menu['children']) && is_array($menu['children'])) {
                    static::installMenus($menu['children'], $model->id, $app, $weight);
                }
            }
        }
    }

    public static function uninstallMenus($app)
    {

        Menu::deleteAll([
            'app' => $app
        ]);
    }

    /**
     * 安装导航
     *
     * @param array $navigations
     * @param number $pid
     * @param string $app
     */
    public static function installNavigations($navigations, $pid = 0, $app = 'frontend', $weight = 50)
    {

        if (is_array($navigations)) {
            foreach ($navigations as $index => $navigation) {
                $children = isset($navigation['children']) ? $navigation['children'] : null;
                $model = new Navigation(['app' => $app]);
                $model->load($navigation, '');
                $model->pid = $pid;
                if (!isset($navigation['requireAuth'])) {
                    $model->requireAuth = 1;
                }
                if (isset($navigation['sort'])) {
                    $model->sort = $navigation['sort'];
                } else if ($pid === 0) {
                    $model->sort = $weight;
                } else {
                    $model->sort = $index;
                }
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if ($children && is_array($children)) {
                    static::installNavigations($navigation['children'], $model->id, $app, $weight);
                }
            }
        }
    }

    public static function uninstallNavigations($app)
    {

        Navigation::deleteAll([
            'app' => $app
        ]);
    }

    /**
     * 安装设置
     *
     * @param array $settings
     * @param string $category
     * @param string $parent
     */
    public static function installSettings($settings, $category = 'base')
    {

        if (is_array($settings)) {
            foreach ($settings as $setting) {
                $children = isset($setting['children']) ? $setting['children'] : null;
                $model = new Setting();
                $model->load($setting, '');
                if (isset($setting['category'])) {
                    $model->category = $setting['category'];
                } else {
                    $model->category = $category;
                }
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if ($children && is_array($children)) {
                    static::installSettings($setting['children'], $category, $model->name);
                }
            }
        }
    }

    public static function uninstallSetting($category)
    {

        Setting::deleteAll([
            'category' => $category
        ]);
    }


    /**
     * 添加路由美化规则
     */
    public static function installPrettyUrl($name, $route, $pattern, $weight = 0)
    {
        $prettyUrl = new PrettyUrl([
            'name' => $name,
            'route' => $route,
            'express' => $pattern,
            'weight' => $weight,
        ]);
        $prettyUrl->save(false);
    }

    public static function installCronJob($script, $name, $time, $intro = null, $param = null)
    {
        $cron = Cron::findOne(['jobScript' => $script]);
        if (!$cron) {
            $cron = new Cron();
            $cron->jobScript = $script;
            $cron->task = $name;
            $cron->mhdmd = $time;
            $cron->intro = $intro;
            $cron->param = $param;
            $cron->isActive = false;
            $cron->save(false);
            if ($cron->hasErrors()) {
                throw new ErrorException(Json::encode($cron->errors));
            }
        }
    }

    public static function uninstallCronJob($scripts)
    {
        Cron::deleteAll(['jobScript' => $scripts]);
    }

    //migration proccess function
    const MIGRATION_TABLE = '{{%migration}}';
    const MIGRATION_MAX_NAME_LENGTH = 180;
    const BASE_MIGRATION = 'm000000_000000_base';
    public static function createMigrationHistoryTable()
    {
        $tableName = Yii::$app->db->schema->getRawTableName(static::MIGRATION_TABLE);
        Yii::$app->db->createCommand()->createTable(static::MIGRATION_TABLE, [
            'version' => 'varchar(' . static::MIGRATION_MAX_NAME_LENGTH . ') NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
        ])->execute();
        Yii::$app->db->createCommand()->insert(static::MIGRATION_TABLE, [
            'version' => static::BASE_MIGRATION,
            'apply_time' => time(),
        ])->execute();
    }

    public static function getMigrationHistory($limit)
    {
        if (Yii::$app->db->schema->getTableSchema(static::MIGRATION_TABLE, true) === null) {
            static::createMigrationHistoryTable();
        }
        $query = (new Query())
            ->select(['version', 'apply_time'])
            ->from(static::MIGRATION_TABLE)
            ->orderBy(['apply_time' => SORT_DESC, 'version' => SORT_DESC]);


        $query->limit($limit);
        $rows = $query->all(Yii::$app->db);
        $history = ArrayHelper::map($rows, 'version', 'apply_time');
        unset($history[static::BASE_MIGRATION]);
        return $history;


        $rows = $query->all(Yii::$app->db);

        $history = [];
        foreach ($rows as $key => $row) {
            if ($row['version'] === static::BASE_MIGRATION) {
                continue;
            }
            if (preg_match('/m?(\d{6}_?\d{6})(\D.*)?$/is', $row['version'], $matches)) {
                $time = str_replace('_', '', $matches[1]);
                $row['canonicalVersion'] = $time;
            } else {
                $row['canonicalVersion'] = $row['version'];
            }
            $row['apply_time'] = (int) $row['apply_time'];
            $history[] = $row;
        }

        usort($history, function ($a, $b) {
            if ($a['apply_time'] === $b['apply_time']) {
                if (($compareResult = strcasecmp($b['canonicalVersion'], $a['canonicalVersion'])) !== 0) {
                    return $compareResult;
                }

                return strcasecmp($b['version'], $a['version']);
            }

            return ($a['apply_time'] > $b['apply_time']) ? -1 : +1;
        });

        $history = array_slice($history, 0, $limit);

        $history = ArrayHelper::map($history, 'version', 'apply_time');

        return $history;
    }

    public static function addMigrationHistory($version)
    {
        $command = Yii::$app->db->createCommand();
        $command->insert(static::MIGRATION_TABLE, [
            'version' => $version,
            'apply_time' => time(),
        ])->execute();
    }

    public static function removeMigrationHistory($version)
    {
        $command = Yii::$app->db->createCommand();
        $command->delete(static::MIGRATION_TABLE, [
            'version' => $version,
        ])->execute();
    }

    public static function createMigration($class)
    {
        /** @var MigrationInterface $migration */
        $migration = Yii::createObject($class);

        return $migration;
    }

    /**
     * Upgrades with the specified migration class.
     * @param string $class the migration class name
     * @return bool whether the migration is successful
     */
    public static function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }
        $migration = static::createMigration($class);
        if ($migration->up() !== false) {
            static::addMigrationHistory($class);
            return true;
        }
        return false;
    }

    /**
     * Downgrades with the specified migration class.
     * @param string $class the migration class name
     * @return bool whether the migration is successful
     */
    public static function migrateDown($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $start = microtime(true);
        $migration = static::createMigration($class);
        if ($migration->down() !== false) {
            static::removeMigrationHistory($class);
            return true;
        }
        return false;
    }

    public static function getAddonMigrations($addonPath, $checkApplied = true)
    {
        $migrationPath = str_replace('/', DIRECTORY_SEPARATOR,  $addonPath . "/Migrations");

        if (!is_dir($migrationPath)) {
            return [];
        }
        $applied = [];
        if ($checkApplied) {

            foreach (static::getMigrationHistory(null) as $class => $time) {
                $applied[trim($class, '\\')] = true;
            }
        }
        $migrations = [];
        $handle = opendir($migrationPath);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $migrationPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_?\d{6})\D.*?)\.php$/is', $file, $matches) && is_file($path)) {
                require $path;
                $class = $matches[1];
                $time = str_replace('_', '', $matches[2]);
                if (!isset($applied[$class])) {
                    $migrations[$time . '\\' . $class] = $class;
                }
            }
        }
        closedir($handle);
        ksort($migrations);
        return array_values($migrations);
    }
}
