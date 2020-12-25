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
            'isFront' => $this->boolean()->defaultValue(1)->comment('是否前端::0:后端|1:前端'),
            'requireAuth' => $this->boolean()->defaultValue(1)->comment('需要鉴权::0:不需要|1:需要'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ],$tableOptions);
        $this->addCommentOnTable('{{%menu}}','菜单');
        
        $this->createTable('{{%navigation}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->comment('父导航D'),
            'name' => $this->string(64)->notNull()->comment('导航名'),
            'url' => $this->string(128)->notNull()->defaultValue('#')->comment('地址::可以是内部和外部地址'),
            'requireLogin' => $this->boolean()->defaultValue(1)->comment('需要登录::0:不需要|1:需要'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'app' => $this->string(64)->notNull()->defaultValue('frontend')->comment('所属APP::前台或后台或插件的Id'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ],$tableOptions);
        $this->addCommentOnTable('{{%navigation}}','前端导航');
        
        //待定
//         $this->createTable('{{%auth_role_menu}}', [
//             'roleId' => $this->string(64)->notNull()->comment('角色ID'),
//             'menuId' => $this->integer()->notNull()->comment('菜单ID'),
//         ],$tableOptions);
//         $this->addCommentOnTable('{{%auth_role_menu}}','角色菜单');
//         $this->addPrimaryKey('pk-auth_role_menu-roleId-menuId', '{{%auth_role_menu}}', ['roleId','menuId']);

        $this->batchInsert('{{%menu}}',[
            'id','pid','name','url','isFront','requireAuth','icon','sort'
        ],[
            [1,0,'Dashboard','default/index',0,1,'fa fa-dashboard',1],
            [2,0,'System','#',0,1,'fa fa-desktop',1000],
            [3,2,'Administrator','administrator/index',0,1,'fa fa-user',1],
            [4,2,'Roles','auth-role/index',0,1,'fa fa-flag',2],
            [5,2,'Permissions','auth-permission/index',0,1,'fa fa-lock',3],
            [6,2,'Rules','auth-rule/index',0,1,'fa fa-key',5],
            [7,2,'Menus','menu/index',0,1,'fa fa-bars',6],
            [8,2,'Logs','action-log/index',0,1,'fa fa-road',6],
            [9,2,'Navigations','navigation/index',0,1,'fa fa-anchor',6],
            [10,0,'Configurations','#',0,1,'fa fa-gears',1100],
            [11,10,'Settings','setting/index',0,1,'fa fa-cog',1],
            [12,10,'Locale and Language','locale/index',0,1,'fa fa-language',2],
            [14,10,'Pretty Url','pretty-url/index',0,1,'fa fa-location-arrow',4],
            [15,10,'Cron Jobs','cron/index',0,1,'fa fa-tasks',5],
            [20,0,'Marketing','#',0,1,'fa fa-gg-circle',900],
            [22,20,'Blocks','block/index',0,1,'fa fa-clone',2],
            [23,0,'Addons','addon/index',0,1,'fa fa-puzzle-piece',1000],
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
