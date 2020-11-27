<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rewrite}}`.
 */
class m201121_151945_create_rewrite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rewrite}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->comment('名称'),
            'express' => $this->string(128)->notNull()->comment('表达式'),
            'weight' => $this->smallInteger()->notNull()->comment('权重'),
            'route' => $this->string(128)->notNull()->comment('路由'),
            'category' => $this->string(64)->notNull()->comment('归类'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rewrite}}');
    }
}