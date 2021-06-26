<?php
use yii\db\Migration;
/**
 * Class m201126_044336_create_cms_adv_tables
 */
class m201126_044336_create_cms_adv_tables extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
    $this->createTable( '{{%cms_adv_block}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string( 128 )->null()->comment( '名称' ),
        'nameCode' => $this->string( 64 )->defaultValue( 'index' )->comment( '编码' ),
        'urlPath' => $this->string( 64 )->defaultValue( '' )->comment( '页面路径' ),
        'pic' => $this->string( 128 )->comment( '图片' ),
        'type' => $this->string( 32 )->defaultValue( 'image' )->comment( '类型::image:图片|js:js代码|html:html代码' ),
        'url' => $this->string( 128 )->comment( '网络地址' ),
        'isFlat' => $this->boolean()->defaultValue( false )->comment( '是否平铺::1:是|0:否' ),
        'content' => $this->text()->comment( '内容' ),
        'startedAt' => $this->dateTime()->null()->comment( '开始时间' ),
        'endAt' => $this->dateTime()->null()->comment( '结束时间' ),
        'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
        'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
    ], $tableOptions );
    $this->createIndex( 'idx-adv_block-code-urlPath', '{{%cms_adv_block}}', [
        'nameCode',
        'urlPath'
    ], true );
    $this->addCommentOnTable( '{{%cms_adv_block}}', '广告位' );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    echo "m201126_044336_create_cms_adv_tables cannot be reverted.\n";
    return false;

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
   * echo "m210626_044336_create_cms_adv_tables cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
