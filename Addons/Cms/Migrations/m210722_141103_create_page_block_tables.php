<?php

use yii\db\Migration;

/**
 * Class m210722_141103_create_page_block_tables
 */
class m210722_141103_create_page_block_tables extends Migration
{
    const TABLE_BLOCK = "{{%cms_page_block}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( static::TABLE_BLOCK, [
            'id'        => $this->primaryKey(),
            'name'      => $this->string( 64 )->notNull()->comment( '名称' ),
            'type'      => $this->string( 16 )->defaultValue( 'element' )->comment( '类型::element:静态元素|layout:布局' ),
            'namespace' => $this->string( 128 )->comment( '命名空间' ),
            'sort'      => $this->smallInteger()->defaultValue( 1 )->comment( '排序' ),
            'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
            'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
        ] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable( static::TABLE_BLOCK );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210722_141103_create_page_block_tables cannot be reverted.\n";

        return false;
    }
    */
}
