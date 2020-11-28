<?php
namespace app\console;

use yii\console\Controller;

/**
 * 件的数据迁移
 * @author dungang
 *        
 */
class AddonMigrateController extends Controller
{
    
    /**
     * 执行数据迁移
     * @param string $addonName
     */
    public function actionIndex($addonName) {
        $this->run("/migrate",[
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }

    /**
     * 执行数据迁移撤回
     * @param string $addonName
     */
    public function actionDown($addonName) {
        echo "test",PHP_EOL;
        $this->run("/migrate/down",[
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }
    
    /**
     * 创建插件的数据迁移
     * @param string $addonName
     * @param string $migrateName
     */
    public function actionCreate($addonName,$migrateName){
       
        $this->run("/migrate/create",[
            $migrateName,
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }
}

