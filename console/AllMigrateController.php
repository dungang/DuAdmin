<?php
namespace app\console;

use yii\console\controllers\MigrateController;
use app\mmadmin\components\Addon;
use yii\helpers\Inflector;

/**
 * 执行所有的模块下的命令
 *
 * @author dungang
 *        
 */
class AllMigrateController extends MigrateController
{

    public function init()
    {
        parent::init();
        foreach (\Yii::$app->modules as $key => $module) {
            if ($module instanceof Addon) {
                $this->migrationPath[] = '@Addons/' . Inflector::id2camel($key) . '/Migrations';
            } else if (is_array($module)) {
                if (isset($module['class'])) {
                    if (substr($module['class'], 0, 6) == 'Addons') {
                        $this->migrationPath[] = '@Addons/' . Inflector::id2camel($key) . '/Migrations';
                    }
                }
            } else if (is_string($module)) {
                if (substr($module, 0, 6) == 'Addons') {
                    $this->migrationPath[] = '@Addons/' . Inflector::id2camel($key) . '/Migrations';
                }
            }
        }
    }
}