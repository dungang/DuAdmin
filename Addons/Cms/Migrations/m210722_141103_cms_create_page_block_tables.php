<?php

use yii\db\Migration;

/**
 * Class m210722_141103_create_page_block_tables
 */
class m210722_141103_cms_create_page_block_tables extends Migration
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

        $this->initBlock( [
            [
                'name'      => '默认轮播',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Carousel\Carousel',
            ], [
                'name'      => '右图左文字Section',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock',
            ], [
                'name'      => '左图右文字Section',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock1',
            ], [
                'name'      => '中间文字Section',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock2',
            ], [
                'name'      => '按钮',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Base\Button',
            ], [
                'name'      => '一级标题',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Base\H1',
            ], [
                'name'      => '二级标题',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Base\H2',
            ], [
                'name'      => '段落',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Base\P',
            ], [
                'name'      => '对话框按钮',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\DialogButton\DialogButton',
            ], [
                'name'      => '列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Container\Container',
            ], [
                'name'      => '1:1容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column11',
            ], [
                'name'      => '2:1容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column21',
            ], [
                'name'      => '1:2列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column12',
            ], [
                'name'      => '1:2:1列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column121',
            ], [
                'name'      => '3列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column3',
            ], [
                'name'      => '4列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column4',
            ], [
                'name'      => '6列表容器',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Columns\Column6',
            ], [
                'name'      => '间隔占位',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Bar\Bar',
            ], [
                'name'      => '白色间隔占位',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\Bar\Bar',
            ], [
                'name'      => '首页banner',
                'type'      => 'layout',
                'namespace' => 'Addons\Cms\PageBlock\Layouts\HomeBanners\HomeBanner',
            ], [
                'name'      => '图片',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Image\Image',
            ], [
                'name'      => '图片信息',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Image\ImageInfo',
            ], [
                'name'      => '联系表单',
                'type'      => 'element',
                'namespace' => 'Addons\Cms\PageBlock\Elements\Contact\Contact',
            ]
        ] );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable( static::TABLE_BLOCK );
    }

    private function initBlock( $blocks = [] )
    {
        foreach ( $blocks as $block ) {
            $block = array_merge( $block, [
                'sort'      => 1,
                'createdAt' => date( 'Y-m-d H:i:s' ),
                'updatedAt' => date( 'Y-m-d H:i:s' ),
            ] );
            $this->insert( static::TABLE_BLOCK, $block );
        }
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
