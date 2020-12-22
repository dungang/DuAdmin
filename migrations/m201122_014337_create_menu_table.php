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
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->comment('父菜单ID'),
            'name' => $this->string(64)->notNull()->comment('菜单名'),
            'url' => $this->string(128)->notNull()->defaultValue('#')->comment('链接'),
            'isFront' => $this->boolean()->defaultValue(1)->comment('是否前端'),
            'requireLogin' => $this->boolean()->defaultValue(1)->comment('需要登录'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ],$tableOptions);
        $this->addCommentOnTable('{{%menu}}','菜单');
        
        //待定
//         $this->createTable('{{%auth_role_menu}}', [
//             'roleId' => $this->string(64)->notNull()->comment('角色ID'),
//             'menuId' => $this->integer()->notNull()->comment('菜单ID'),
//         ],$tableOptions);
//         $this->addCommentOnTable('{{%auth_role_menu}}','角色菜单');
//         $this->addPrimaryKey('pk-auth_role_menu-roleId-menuId', '{{%auth_role_menu}}', ['roleId','menuId']);

        $this->batchInsert('{{%menu}}',[
            'id','pid','name','url','isFront','requireLogin','icon','sort'
        ],[
            [1,0,'Dashboard','?r=default/index',0,1,'fa fa-dashboard',1],
            [2,0,'System','#',0,1,'fa fa-desktop',100],
            [3,2,'Administrator','?r=administrator/index',0,1,'fa fa-user',1],
            [4,2,'Roles','?r=auth-role/index',0,1,'fa fa-flag',2],
            [5,2,'Permissions','?r=auth-permission/index',0,1,'fa fa-lock',3],
            [7,2,'Rules','?r=auth-rule/index',0,1,'fa fa-key',5],
            [8,2,'Menus','?r=menu/index',0,1,'fa fa-bars',6],
            [9,2,'Logs','?r=action-log/index',0,1,'fa fa-road',6],
            [10,0,'Configurations','#',0,1,'fa fa-gears',110],
            [11,10,'Settings','?r=setting/index',0,1,'fa fa-cog',1],
            [12,10,'Locale and Language','?r=locale/index',0,1,'fa fa-language',2],
            [14,10,'Pretty Url','?r=pretty-url/index',0,1,'fa fa-location-arrow',4],
            [15,10,'Cron Jobs','?r=cron/index',0,1,'fa fa-tasks',5],
            [16,10,'Addon Navigation','?r=addon-navigation/index',0,1,'fa fa-bars',6],
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
