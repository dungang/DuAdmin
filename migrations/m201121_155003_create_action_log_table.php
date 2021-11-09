<?php
use yii\db\Migration;
/**
 * Handles the creation of table `{{%action_log}}`.
 */
class m201121_155003_create_action_log_table extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $this->createTable( '{{%action_log}}', [
        'id' => $this->primaryKey(),
        'userId' => $this->integer()->notNull()->comment( '用户' ),
        'action' => $this->string( 128 )->comment( '行为' ),
        'ip' => $this->string( 32 )->null()->comment( 'IP' ),
        'method' => $this->string( 8 )->comment( '方法' ),
        'sourceType' => $this->string( 16 )->comment( '来源::Backend:后台|Frontend:前台|Api:API' ),
        'createdAt' => $this->dateTime()->null()->comment( '时间' ),
        'data' => $this->text()->comment( '数据' )
    ]);
    $this->addCommentOnTable( '{{%action_log}}', '操作日志' );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->dropTable( '{{%action_log}}' );

  }
}
