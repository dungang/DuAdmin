<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m201122_014337_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->comment('父菜单ID'),
            'name' => $this->string(64)->notNull()->comment('菜单名'),
            'url' => $this->string(128)->notNull()->defaultValue('#')->comment('链接'),
            'is_front' => $this->boolean()->defaultValue(1)->comment('是否前端'),
            'require_login' => $this->boolean()->defaultValue(1)->comment('需要登录'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ]);

        $this->batchInsert('{{%menu}}',[
            'id','pid','name','url','is_front','require_login','icon','sort'
        ],[
            [1,0,'Dashboard','?r=default/index',0,1,'fa fa-dashboard',1],
            [2,0,'System','#',0,1,'fa fa-desktop',100],
            [3,2,'Administrator','?r=administrator/index',0,1,'fa fa-user',1],
            [4,2,'Roles','?r=auth-role/index',0,1,'fa fa-flag',2],
            [5,2,'Permissions','?r=auth-permission/index',0,1,'fa fa-lock',3],
            [6,2,'Auth Groups','?r=auth-group/index',0,1,'fa fa-puzzle-piece',4],
            [7,2,'Rules','?r=auth-rule/index',0,1,'fa fa-key',5],
            [8,2,'Menus','?r=menu/index',0,1,'fa fa-bars',6],
            [9,2,'Logs','?r=action-log/index',0,1,'fa fa-road',6],
            [10,0,'Configurations','#',0,1,'fa fa-gears',110],
            [11,10,'Settings','?r=setting/index',0,1,'fa fa-cog',1],
            [12,10,'Locale and Language','?r=locale/index',0,1,'fa fa-language',2],
            [13,10,'Assets','?r=asset/manage',0,1,'fa fa-cogs',3],
            [14,10,'Pretty Url','?r=pretty-url/index',0,1,'fa fa-location-arrow',4],
            [15,10,'Cron Jobs','?r=cron/index',0,1,'fa fa-tasks',5],
            [20,0,'Marketing','#',0,1,'fa fa-gg-circle',40],
            [21,20,'Blocks','?r=block/index',0,1,'fa fa-clone',1],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
