<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cron}}`.
 */
class m201121_154848_create_cron_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cron}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cron}}');
    }
}
