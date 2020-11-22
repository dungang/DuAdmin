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
        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255)->comment('类别'),
            'message' => $this->text()->comment('原文')
        ]);

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(16)->comment('语言'),
            'translation' => $this->text()->comment('翻译')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201121_154919_create_source_message_tables cannot be reverted.\n";

        return false;
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
