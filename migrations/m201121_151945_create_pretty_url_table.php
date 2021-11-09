<?php
use yii\db\Migration;
class m201121_151945_create_pretty_url_table extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $this->createTable( '{{%pretty_url}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string( 64 )->notNull()->comment( '名称' ),
        'express' => $this->string( 128 )->notNull()->comment( '表达式' ),
        'weight' => $this->smallInteger()->notNull()->comment( '权重' ),
        'route' => $this->string( 128 )->notNull()->comment( '路由' )
    ]);
    $this->addCommentOnTable( '{{%pretty_url}}', 'URL美化' );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->dropTable( '{{%pretty_url}}' );

  }
}

