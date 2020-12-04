<?php

use yii\db\Migration;

/**
 * Class m201121_154919_create_source_message_tables
 */
class m201121_154919_create_source_message_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255)->comment('类别'),
            'message' => $this->text()->comment('原文')
        ],$tableOptions);

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(16)->comment('语言'),
            'translation' => $this->text()->comment('翻译')
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%source_message}}');
        $this->dropTable('{{%message}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201121_154919_create_source_message_tables cannot be reverted.\n";

        return false;
    }
    */
}
