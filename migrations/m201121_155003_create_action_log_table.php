<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%action_log}}`.
 */
class m201121_155003_create_action_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%action_log}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%action_log}}');
    }
}
