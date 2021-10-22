<?php

use yii\db\Migration;

/**
 * Class m201123_150949_create_page_tables
 */
class m201123_150949_create_page_tables extends Migration
{

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp()
  {

    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
    $this->createTable('{{%cms_page}}', [
      'id' => $this->primaryKey(),
      'pid' => $this->integer()->defaultValue(0)->comment('父页'),
      'slug' => $this->string(128)->comment('页面路径'),
      'title' => $this->string(128)->null()->comment('标题'),
      'keywords' => $this->string('128')->null()->comment('关键字'),
      'description' => $this->string('255')->null()->comment('简介'),
      'isLiveEdit' => $this->boolean()->defaultValue(1)->comment("在线编辑"),
      'showMode' => $this->string(32)->defaultValue('full')->comment("在线编辑"), // full 完整显示 content 只显示内容  nohead 不显示头部
      'sort' => $this->smallInteger()->defaultValue(1)->comment('排序'),
      'createdAt' => $this->dateTime()->null()->comment('添加时间'),
      'updatedAt' => $this->dateTime()->null()->comment('更新时间')
    ], $tableOptions);
    $this->createIndex('idx-page-slug', '{{%cms_page}}', 'slug', true);
    $this->addCommentOnTable('{{%cms_page}}', '单页');

    $this->createTable('{{%cms_page_post}}', [
      'pageId' => $this->integer()->comment('页ID'),
      'language' => $this->char(5)->defaultValue('zh-CN')->comment('语言'),
      'title' => $this->string(128)->null()->comment('标题'),
      'content' => $this->text()->null()->comment('内容'),
      'createdAt' => $this->dateTime()->null()->comment('添加时间'),
      'updatedAt' => $this->dateTime()->null()->comment('更新时间')
    ], $tableOptions);
    $this->addCommentOnTable('{{%cms_page_post}}', '页面内容');
    $this->addPrimaryKey('pk-page_post-pageId-language', '{{%cms_page_post}}', [
      'pageId',
      'language'
    ]);
  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown()
  {

    $this->dropTable('{{%page}}');
    $this->dropTable('{{%page_post}}');
  }
  /*
   * // Use up()/down() to run migration code without a transaction.
   * public function up()
   * {
   *
   * }
   *
   * public function down()
   * {
   * echo "m201123_150949_create_page_tables cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
