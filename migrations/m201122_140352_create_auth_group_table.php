<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_group}}`.
 */
class m201122_140352_create_auth_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable('{{%auth_group}}', [
            'name' => $this->string(128)->comment('组标识'),
            'title' => $this->string(128)->comment('组标题'),
            'type' => $this->smallInteger()->defaultValue(1)->comment('类型'),
            'isBackend' => $this->boolean()->defaultValue(true)->comment('是否后台')
        ],$tableOptions);
        $this->addCommentOnTable('{{%auth_group}}','权限组');
        $this->addPrimaryKey('pk-auth_group-name','{{%auth_group}}','name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_group}}');
    }
}
