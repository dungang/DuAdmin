<?php

namespace Console;

use yii\console\controllers\MigrateController;
use yii\base\NotSupportedException;
use yii\helpers\BaseFileHelper;

/**
 * 执行所有的模块下的命令
 *
 * @author dungang
 *        
 */
class DuaMigrateController extends MigrateController
{

    public function init()
    {
        parent::init();
        $dirs = BaseFileHelper::findDirectories(\Yii::$app->basePath . '/Addons', [
            'recursive' => false
        ]);
        $installedAddons = require dirname(__DIR__) . "/Config/installed-addons.php";
        foreach ($dirs as $name) {
            $addonName = basename($name);
            if (in_array($addonName, $installedAddons)) {
                $this->migrationPath[] = '@Addons/' . $addonName . '/Migrations';
            }
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\console\controllers\BaseMigrateController::actionCreate()
     */
    public function actionCreate($name)
    {
        throw new NotSupportedException();
    }
}
