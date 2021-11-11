<?php

use Console\components\Migration;

/**
 * Handles the creation of table `{{%flash}}`.
 */
class m201124_075757_cms_create_flash_table extends Migration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable( '{{%cms_flash}}', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string( 64 )->notNull()->comment( '名称' ),
            'pic'       => $this->string( 128 )->notNull()->comment( '图片' ),
            'url'       => $this->string( 128 )->null()->comment( '地址' ),
            'bgColor'   => $this->string( 255 )->null()->comment( '背景' ),
            'sort'      => $this->smallInteger()->defaultValue( 1 )->comment( '排序' ),
            'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
            'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
        ]);
        $this->addCommentOnTable( '{{%cms_flash}}', '轮播' );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable( '{{%flash}}' );
    }

}
