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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cron}}');
    }
}
