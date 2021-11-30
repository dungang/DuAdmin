<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin}}`.
 */
class m201121_070432_create_system_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_rule}}', [
            'id' => $this->string(64)->notNull()->comment('ID'),
            'name' => $this->string(64)->notNull()->comment('描述'),
            'data' => $this->binary()->null()->comment('数据'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
            'PRIMARY KEY ([[id]])'
        ]);

        $this->addCommentOnTable('{{%auth_rule}}', '权限规则');

        $this->createTable('{{%auth_item}}', [
            'id' => $this->string(64)->notNull()->comment('ID::路由ID或者角色，组的英文表示'),
            'type' => $this->smallInteger()->notNull()->comment('类型::1:角色|2:权限|3:组'),
            'name' => $this->string(64)->comment('说明'),
            'ruleId' => $this->string(64)->null()->comment('规则ID'),
            'data' => $this->binary()->null()->comment('数据'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
            'PRIMARY KEY ([[id]])'
        ]);
        $this->addCommentOnTable('{{%auth_item}}', '权限');
        $this->addForeignKey('fk-auth_item-ruleId', '{{%auth_item}}', 'ruleId', '{{%auth_rule}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');

        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull()->comment('上级'),
            'child' => $this->string(64)->notNull()->comment('下级'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
            'PRIMARY KEY ([[parent]], [[child]])'
        ]);
        $this->addCommentOnTable('{{%auth_item_child}}', '子权限');
        $this->addForeignKey('fk-auth_item_child-parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-auth_item_child-child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%auth_assignment}}', [
            'itemId' => $this->string(64)->notNull()->comment('权限'),
            'userId' => $this->string(64)->notNull()->comment('用户ID'),
            'createdAt' => $this->dateTime()->comment('添加时间'),
            'PRIMARY KEY ([[itemId]], [[userId]])'
        ]);
        $this->addCommentOnTable('{{%auth_assignment}}', '授权');
        $this->addForeignKey('fk-auth_assignment-item_name', '{{%auth_assignment}}', 'itemId', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->unique()->notNull()->comment("用户名"),
            'nickname' => $this->string(32)->null()->comment('昵称'),
            'avatar' => $this->string(255)->null()->comment('头像'),
            'authKey' => $this->string(128)->null()->comment('授权KEY'),
            'passwordHash' => $this->string(128)->null()->comment('密码hash'),
            'passwordResetToken' => $this->string(128)->null()->comment('密码重置token'),
            'email' => $this->string(64)->null()->unique()->comment('邮箱'),
            'mobile' => $this->string(16)->null()->unique()->comment('手机'),
            'status' => $this->tinyInteger()->defaultValue(10)->comment('状态::0:未激活|10:已激活'),
            'isSuper' => $this->tinyInteger()->defaultValue(0)->comment('是否超管::0:普通成员|1:超级管理员'),
            'loginAt' => $this->dateTime()->null()->comment('上次登陆时间'),
            'loginFailure' => $this->string(255)->null()->comment('登陆失败消息'),
            'loginIp' => $this->string(64)->null()->comment('登录IP'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%admin}}', '管理员');

        $this->createTable('{{%pretty_url}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->comment('名称'),
            'express' => $this->string(128)->notNull()->comment('表达式'),
            'weight' => $this->smallInteger()->notNull()->comment('权重'),
            'route' => $this->string(128)->notNull()->comment('路由')
        ]);
        $this->addCommentOnTable('{{%pretty_url}}', 'URL美化');
        $this->createTable('{{%cron}}', [
            'id' => $this->primaryKey(),
            'task' => $this->string(64)->comment('任务'),
            'mhdmd' => $this->string(128)->comment('定时'),
            'jobScript' => $this->string(255)->comment('脚本'),
            'param' => $this->string(255)->null()->comment('参数'),
            'intro' => $this->string(255)->null()->comment('说明'),
            'token' => $this->string(255)->null()->comment('安全token'),
            'errorMsg' => $this->string(255)->null()->comment('错误消息'),
            'isOk' => $this->boolean()->defaultValue(true)->comment('运行状况::0:错误|1:正常'),
            'isActive' => $this->boolean()->defaultValue(false)->comment('是否激活::0:不激活|1:激活'),
            'app' => $this->string(128)->defaultValue('backend')->comment('归属应用'),
            'runAt' => $this->dateTime()->null()->comment('执行时间'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%cron}}', '定时任务');
        $this->createTable('{{%action_log}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->comment('用户'),
            'action' => $this->string(128)->comment('行为'),
            'ip' => $this->string(32)->null()->comment('IP'),
            'method' => $this->string(8)->comment('方法'),
            'sourceType' => $this->string(16)->comment('来源::Backend:后台|Frontend:前台|Api:API'),
            'createdAt' => $this->dateTime()->null()->comment('时间'),
            'data' => $this->text()->comment('数据')
        ]);
        $this->addCommentOnTable('{{%action_log}}', '操作日志');
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->comment('父菜单ID'),
            'name' => $this->string(64)->notNull()->comment('菜单名'),
            'url' => $this->string(128)->notNull()->defaultValue('#')->comment('链接'),
            'isOuter' => $this->boolean()->defaultValue(0)->comment('是否外部链接::0:否|1:是'),
            'requireAuth' => $this->boolean()->defaultValue(1)->comment('需要鉴权::0:不需要|1:需要'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'app' => $this->string(64)->notNull()->defaultValue('core')->comment('所属APP::后台或插件的Id'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序')
        ]);
        $this->addCommentOnTable('{{%menu}}', '菜单');
        $this->createTable('{{%navigation}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->comment('父导航D'),
            'name' => $this->string(64)->notNull()->comment('导航名'),
            'intro' => $this->string(128)->null()->comment('介绍'),
            'url' => $this->string(128)->notNull()->defaultValue('#')->comment('地址::可以是内部和外部地址'),
            'isOuter' => $this->boolean()->defaultValue(0)->comment('是否外部链接::0:否|1:是'),
            'requireAuth' => $this->boolean()->defaultValue(0)->comment('需要登录::0:不需要|1:需要'),
            'icon' => $this->string(64)->null()->comment('ICON'),
            'app' => $this->string(64)->notNull()->defaultValue('frontend')->comment('所属APP::前台或后台或插件的Id'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序')
        ]);
        $this->addCommentOnTable('{{%navigation}}', '前端导航');

        $this->createTable('{{%dashboard_widget}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->comment("名称"),
            'widget' => $this->string(128)->notNull()->comment("小部件"),
            'args' => $this->string(128)->comment("参数"),
            'argsInfo' => $this->string(255)->comment("参数说明"),
            'status' => $this->boolean()->defaultValue(true)->comment("状态"),
            'sort' => $this->tinyInteger()->defaultValue(1)->comment("排序"),
            'type' => $this->string(8)->defaultValue("counter")->comment("类型"), //counter数量，charts 图表
        ]);
        $this->addCommentOnTable("{{%dashboard_widget}}", "看板数据小部件");

        $this->createTable('{{%addon}}', [
            'id' => $this->string(64),
            'name' => $this->string(64)->notNull()->comment('名称'),
            'intro' => $this->string(255)->null()->comment('简介'),
            'hasSetting' => $this->boolean()->notNull()->defaultValue(false)->comment('设置::0:无|1:有'),
            'hasBackend' => $this->boolean()->notNull()->defaultValue(false)->comment('后端::0:无|1:有'),
            'hasFrontend' => $this->boolean()->notNull()->defaultValue(false)->comment('前端::0:无|1:有'),
            'hasApi' => $this->boolean()->notNull()->defaultValue(false)->comment('API::0:无|1:有'),
            'type' => $this->string(64)->notNull()->defaultValue('component')->comment('类型'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%addon}}', '插件');

        $this->createTable("{{%mail_template}}", [
            'id' => $this->primaryKey(),
            'code' => $this->string("32")->notNull()->unique()->comment("业务编码::建议以应标识为前缀避免碰撞"),
            'title' => $this->string(128)->notNull()->comment("邮件名称"),
            'content' => $this->text()->comment("邮件内容"),
            'varsInfo' => $this->string(255)->comment("变量说明"),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%mail_template}}', '邮件模板');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item_children}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%admin}}');
        $this->dropTable('{{%pretty_url}}');
        $this->dropTable('{{%cron}}');
        $this->dropTable('{{%action_log}}');
        $this->dropTable('{{%menu}}');
        $this->dropTable('{{%navigation}}');
        $this->dropTable('{{%dashboard_widget}}');
        $this->dropTable('{{%addon}}');
    }
}
