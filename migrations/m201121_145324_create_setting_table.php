<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m201121_145324_create_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%setting}}', [
            'name' => $this->string(64)->notNull()->comment('变量名'),
            'title' => $this->string(64)->notNull()->comment('变量标题'),
            'value' => $this->text()->null()->comment('变量值'),
            'value_type' => $this->string(64)->notNull()->comment('值类型'),
            'hint' => $this->string(255)->null()->comment('变量介绍'),
            'category' => $this->string(64)->notNull()->defaultValue('base')->comment('变量标题')
        ]);
        $this->addPrimaryKey('px-setting-name','{{%setting}}','name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
    }
}
