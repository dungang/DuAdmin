<?php
namespace Console;

/**
 * 件的数据迁移
 *
 * @author dungang
 *        
 */
class AddonMigrateController extends BaseController
{

    /**
     * 执行数据迁移
     */
    public function actionIndex()
    {
        $addonName = $this->selectOneAddonName();
        $this->run("/migrate", [
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }

    /**
     * 执行数据迁移撤回
     */
    public function actionDown()
    {
        $addonName = $this->selectOneAddonName();
        $this->run("/migrate/down", [
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }

    /**
     * 创建插件的数据迁移
     */
    public function actionCreate()
    {
        $addonName = $this->selectOneAddonName();
        $migrateName = $this->prompt("请输入数据迁移名称", [
            'required' => true
        ]);
        $this->run("/migrate/create", [
            $migrateName,
            'migrationPath' => '@Addons/' . $addonName . '/Migrations'
        ]);
    }
}

