<?php

use yii\db\Migration;

/**
 * Class m201121_084512_create_auth_tables
 */
class m201121_084512_create_auth_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull()->comment('名称'),
            'data' => $this->binary()->comment('数据'),
            'created_at' => $this->integer()->comment('添加时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);

        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull()->comment('名称'),
            'type' => $this->smallInteger()->notNull()->comment('类型'),
            'description' => $this->text()->comment('说明'),
            'rule_name' => $this->string(64)->comment('规则'),
            'group_name' => $this->string(128)->comment('组'),
            'data' => $this->binary()->comment('数据'),
            'created_at' => $this->integer()->comment('添加时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);
        $this->addForeignKey('fk-auth_item-rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'SET NULL', 'CASCADE');
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');

        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string(64)->notNull()->comment('上级'),
            'child' => $this->string(64)->notNull()->comment('下级'),
            'PRIMARY KEY ([[parent]], [[child]])',
        ], $tableOptions);
        $this->addForeignKey('fk-auth_item_child-parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-auth_item_child-child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull()->comment('权限'),
            'user_id' => $this->string(64)->notNull()->comment('用户ID'),
            'created_at' => $this->integer()->comment('添加时间'),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
        ], $tableOptions);
        $this->addForeignKey('fk-auth_assignment-item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
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
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201121_084512_create_auth_tables cannot be reverted.\n";

        return false;
    }
    */
}
