<?php

use yii\db\Migration;

/**
 * Class m201123_150938_create_cms_tables
 */
class m201123_150938_create_cms_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable('{{%post_category}}',[
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->defaultValue(0)->comment('父类'),
            'name' => $this->string(64)->comment('分类名称'),
            'slug' => $this->string(64)->comment('Slug'),
            'template' => $this->string(64)->comment('模板'),
            'intro' => $this->string(255)->comment('说明'),
            'sort' => $this->smallInteger()->defaultValue(1)->comment('排序')
        ],$tableOptions);

        $this->addCommentOnTable('{{%post_category}}','文章分类');
        $this->createIndex('idx-post_category-slug','{{%post_category}}','slug',true);

        $this->createTable('{{%post}}',[
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->comment('编辑ID'),
            'cateId' => $this->integer()->comment('分类ID'),
            'slug' => $this->string(128)->comment('Slug'),
            'title' => $this->string('128')->null()->comment('标题'),
            'cover' => $this->string('128')->null()->comment('首图'),
            'keywords' => $this->string('128')->null()->comment('关键字'),
            'description' => $this->string('255')->null()->comment('简介'),
            'content' => $this->text()->null()->comment('内容'),
            'isPublished' => $this->boolean()->defaultValue(false)->comment('发布状态'),
            'viewTimes' => $this->integer()->defaultValue(0)->comment('阅读次数'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ],$tableOptions);
        $this->addCommentOnTable('{{%post}}','文章');
        $this->createIndex('idx-post-post_category','{{%post}}','cateId');
        $this->createIndex('idx-post-userId','{{%post}}','userId');
        $this->createIndex('idx-post-slug','{{%post}}','slug',true);
        
        $this->insert("{{%post_category}}", [
            'name' => '默认分类',
            'slug' => 'default',
            'intro' => '默认分类'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%post_category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201123_150938_create_cms_tables cannot be reverted.\n";

        return false;
    }
    */
}
