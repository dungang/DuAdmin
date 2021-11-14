<?php

namespace DuAdmin\Components;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Helpers\LoaderHelper;
use DuAdmin\Mysql\Query;
use Exception;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class AddonInstaller extends BaseObject
{

    public $migrationTable = '{{%migration}}';
    public $addonName;

    const MIGRATION_MAX_NAME_LENGTH = 180;
    const BASE_MIGRATION = 'm000000_000000_base';

    public function init()
    {
        if (empty($this->addonName)) {
            throw new BizException("插件标识不能为空");
        }
        //$this->migrationTable = "{{%migration_" . Inflector::camel2id($this->addonName, "_") . "}}";
        $this->ensureMigrationTableExisted();
    }

    public function createMigrationHistoryTable()
    {
        Yii::$app->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'varchar(' . static::MIGRATION_MAX_NAME_LENGTH . ') NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
            'app' => 'varchar(' . static::MIGRATION_MAX_NAME_LENGTH . ') NOT NULL DEFAULT "system"'
        ])->execute();
        Yii::$app->db->createCommand()->insert($this->migrationTable, [
            'version' => static::BASE_MIGRATION,
            'apply_time' => time(),
        ])->execute();
    }

    public function ensureMigrationTableExisted()
    {
        if (Yii::$app->db->schema->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationHistoryTable();
        }
    }

    public function getMigrationHistory($limit)
    {
        $query = (new Query())
            ->select(['version', 'apply_time'])
            ->from($this->migrationTable)
            ->where(['app' => $this->addonName])
            ->orWhere(['version' => static::BASE_MIGRATION])
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

    public function addMigrationHistory($version)
    {
        $command = Yii::$app->db->createCommand();
        $command->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
            'app' => $this->addonName
        ])->execute();
    }

    public function removeMigrationHistory($version)
    {
        $command = Yii::$app->db->createCommand();
        $command->delete($this->migrationTable, [
            'version' => $version,
            'app' => $this->addonName
        ])->execute();
    }

    public function createMigration($class)
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
    public function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }
        $migration = $this->createMigration($class);
        if ($migration->up() !== false) {
            $this->addMigrationHistory($class);
            return true;
        }
        return false;
    }

    /**
     * Downgrades with the specified migration class.
     * @param string $class the migration class name
     * @return bool whether the migration is successful
     */
    public function migrateDown($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }
        $migration = $this->createMigration($class);
        if ($migration->down() !== false) {
            $this->removeMigrationHistory($class);
            return true;
        }
        return false;
    }

    public function getAddonMigrations($checkApplied = true)
    {
        $addonPath = \Yii::$app->basePath . '/Addons/' . $this->addonName;

        $migrationPath = str_replace('/', DIRECTORY_SEPARATOR,  $addonPath . "/Migrations");

        if (!is_dir($migrationPath)) {
            return [];
        }
        $applied = [];
        if ($checkApplied) {

            foreach ($this->getMigrationHistory(null) as $class => $time) {
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

    public function install()
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $this->addonName;
        if (is_dir($dirPath)) {
            $installed = LoaderHelper::loadInstalledAddonsConfig();
            $installed[] = $this->addonName;
            LoaderHelper::saveInstalledAddonsConfig($installed);
            $addonInstaller = new AddonInstaller(['addonName' => $this->addonName]);
            $migrations = $addonInstaller->getAddonMigrations();
            if ($migrations) {
                foreach ($migrations as $migration) {
                    try {
                        $addonInstaller->migrateUp($migration);
                    } catch (Exception $e) {
                        Yii::error($e->getMessage());
                        throw new BizException("安装数据出错:" . $e->getMessage());
                    }
                }
                AppHelper::cleanSettingRelationCache();
            }
            return true;
        }
        throw new BizException("插件不存在");
    }


    public function uninstall()
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $this->addonName;
        if (is_dir($dirPath)) {
            $installed = LoaderHelper::loadInstalledAddonsConfig();
            $installed = array_filter($installed, function ($el) {
                if ($el == $this->addonName) {
                    return false;
                } else {
                    return true;
                }
            });
            LoaderHelper::saveInstalledAddonsConfig($installed);
            $addonInstaller = new AddonInstaller(['addonName' => $this->addonName]);
            $migrations = $addonInstaller->getAddonMigrations(false);
            if ($migrations) {
                foreach ($migrations as $migration) {
                    try {
                        $addonInstaller->migrateDown($migration);
                    } catch (Exception $e) {
                        Yii::error($e->getMessage());
                        throw new BizException("卸载数据出错:" . $e->getMessage());
                    }
                }
                AppHelper::cleanSettingRelationCache();
            }
            return true;
        }
        throw new BizException("插件不存在");
    }
}
