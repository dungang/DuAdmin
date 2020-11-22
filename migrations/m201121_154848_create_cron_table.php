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
            'task' => $this->string(64)->comment('任务'),
            'mhdmd' => $this->string(128)->comment('定时'),
            'job_script' => $this->string(255)->comment('脚本'),
            'param' => $this->string(255)->null()->comment('参数'),
            'intro' => $this->string(255)->null()->comment('说明'),
            'token' => $this->string(255)->null()->comment('安全token'),
            'error_msg' => $this->string(255)->null()->comment('错误消息'),
            'is_ok' => $this->boolean()->defaultValue(true)->comment('正常'),
            'is_active' => $this->boolean()->defaultValue(false)->comment('激活'),
            'run_at' => $this->integer()->null()->comment('执行时间'),
            'created_at' => $this->integer()->null()->comment('添加时间'),
            'updated_at' => $this->integer()->null()->comment('更新时间'),
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
