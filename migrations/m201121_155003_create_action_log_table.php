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
            'user_id' => $this->integer()->notNull()->comment('用户'),
            'action' => $this->string(128)->comment('行为'),
            'ip'=>$this->integer()->null()->comment('IP'),
            'method' => $this->string(8)->comment('方法'),
            'created_at' => $this->timestamp()->null()->comment('时间'),
            'data' => $this->text()->comment('数据')
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
