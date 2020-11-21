<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail_queue}}`.
 */
class m201121_154943_create_mail_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mail_queue}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_queue}}');
    }
}
