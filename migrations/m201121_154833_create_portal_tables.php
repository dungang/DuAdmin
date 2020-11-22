<?php

use yii\db\Migration;

/**
 * Class m201121_154833_create_portal_tables
 */
class m201121_154833_create_portal_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%portal}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->comment('名称'),
            'code' => $this->string(128)->notNull()->comment('代码类'),
            'source' => $this->string(32)->notNull()->comment('来源'),
            'is_static' => $this->boolean()->defaultValue(true)->comment('是否统计'),
            'unlimited' => $this->boolean()->defaultValue(false)->comment('是否无限制'),
        ]);

        $this->createTable('{{%portal_place}}',[
            'admin_id' => $this->integer()->notNull()->comment('管理员ID'),
            'portals' => $this->text()->null()->comment('Portals'),
        ]);

        $this->addPrimaryKey('pk-portal_place-admin_id','{{%portal_place}}','admin_id');

        $this->createTable('{{%portal_privilege}}',[
            'role' => $this->string(64)->notNull()->comment('角色'),
            'portals' => $this->text()->null()->comment('Portals'),
        ]);

        $this->addPrimaryKey('pk-portal_privilege-role','{{%portal_privilege}}','role');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201121_154833_create_portal_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201121_154833_create_portal_tables cannot be reverted.\n";

        return false;
    }
    */
}
