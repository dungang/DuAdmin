<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_block}}`.
 */
class m201225_132002_create_page_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->createTable('{{%page_block}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64)->notNull()->comment("标题"),
            'widget' => $this->string()->notNull()->comment('小部件'),
            'sourceApp' => $this->string(128)->notNull()->comment('来源App'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        
        $this->createTable('{{%page_block_data}}', [
            'id' => $this->primaryKey(),
            'showTitle' => $this->string(64)->null()->comment("显示标题"),
            'size' => $this->smallInteger()->defaultValue(1)->comment('数量'),
            'background' => $this->string(255)->null()->comment('背景'),
            'isActive' => $this->boolean()->defaultValue(0)->comment('是否激活::1:是|0:否'),
            'widget' => $this->string()->notNull()->comment('小部件'),
            'sourceApp' => $this->string(128)->notNull()->comment('来源App'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_block}}');
    }
}
