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
        $this->createTable('{{%auth_group}}', [
            'name' => $this->string(128)->comment('组标识'),
            'title' => $this->string(128)->comment('组标题'),
            'type' => $this->smallInteger()->defaultValue(1)->comment('类型'),
            'is_backend' => $this->boolean()->defaultValue(true)->comment('是否后台')
        ]);
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
