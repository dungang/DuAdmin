<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_block}}`.
 */
class m201125_132002_create_page_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->createTable('{{%page_block}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->comment("名称"),
            'widget' => $this->string()->notNull()->comment('小部件'),
            'sourceApp' => $this->string(128)->notNull()->comment('来源App'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%page_block}}','首页块');
        
        $this->createTable('{{%page_block_data}}', [
            'id' => $this->primaryKey(),
            'blockId' => $this->integer()->notNull()->comment('块ID'),
            'showTitle' => $this->string(64)->null()->comment("显示标题"),
            'filter' => $this->string(255)->null()->comment('过滤条件::如 name=duadmin&id=du 使用queryString格式'),
            'size' => $this->smallInteger()->defaultValue(1)->comment('数量'),
            'orderBy' => $this->string(32)->null()->comment('显示排序::如 id DESC, sort ASC'),
            'style' => $this->string(255)->null()->comment('样式'),
            'enableCache' => $this->boolean()->defaultValue(false)->comment('是否缓存::1:是|0:否'),
            'expiredAt' => $this->dateTime()->null()->comment('缓存过期时间'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ]);
        $this->addCommentOnTable('{{%page_block_data}}','首页块数据');
        $this->createIndex("fk-page_block_data-blockId","{{%page_block_data}}", ['blockId']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_block}}');
        $this->dropTable('{{%page_block_data}}');
    }
}
