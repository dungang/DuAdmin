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

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '默认轮播',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Carousel\Carousel',
            'sort'      => 1,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '右图左文字Section',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '左图右文字Section',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock1',
            'sort'      => 3,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '对话框按钮',
            'type'      => 'element',
            'namespace' => 'Addons\Cms\PageBlock\Elements\DialogButton\DialogButton',
            'sort'      => 1,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '列表容器',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Container\Container',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '1:1容器',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column11',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '2:1容器',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column21',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '1:2列表容器',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column12',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
        ] );

        $this->insert( static::TABLE_BLOCK, [
            'name'      => '间隔占位',
            'type'      => 'layout',
            'namespace' => 'Addons\Cms\PageBlock\Layouts\Bar\Bar',
            'sort'      => 2,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' ),
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
