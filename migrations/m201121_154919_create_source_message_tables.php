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
