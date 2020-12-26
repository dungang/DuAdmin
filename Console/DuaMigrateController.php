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
        foreach ($dirs as $name) {
            $addonName = basename($name);
            $this->migrationPath[] = '@Addons/' . $addonName . '/Migrations';
        }
        //print_r($this->migrationPath);die;
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