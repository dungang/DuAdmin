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

