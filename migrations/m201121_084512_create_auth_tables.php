<?php
use yii\db\Migration;

/**
 * Class m201121_084512_create_auth_tables
 */
class m201121_084512_create_auth_tables extends Migration {
  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {
    $this->createTable ( '{{%auth_rule}}', [
        'id' => $this->string ( 64 )->notNull ()->comment ( 'ID' ),
        'name' => $this->string ( 64 )->notNull ()->comment ( '描述' ),
        'data' => $this->binary ()->null ()->comment ( '数据' ),
        'createdAt' => $this->dateTime ()->null ()->comment ( '添加时间' ),
        'updatedAt' => $this->dateTime ()->null ()->comment ( '更新时间' ),
        'PRIMARY KEY ([[id]])'
    ]);

    $this->addCommentOnTable ( '{{%auth_rule}}', '权限规则' );

    $this->createTable ( '{{%auth_item}}', [
        'id' => $this->string ( 64 )->notNull ()->comment ( 'ID::路由ID或者角色，组的英文表示' ),
        'type' => $this->smallInteger ()->notNull ()->comment ( '类型::1:角色|2:权限|3:组' ),
        'name' => $this->string ( 64 )->comment ( '说明' ),
        'ruleId' => $this->string ( 64 )->null ()->comment ( '规则ID' ),
        'data' => $this->binary ()->null ()->comment ( '数据' ),
        'sort' => $this->smallInteger ()->defaultValue ( 0 )->comment ( '排序' ),
        'createdAt' => $this->dateTime ()->null ()->comment ( '添加时间' ),
        'updatedAt' => $this->dateTime ()->null ()->comment ( '更新时间' ),
        'PRIMARY KEY ([[id]])'
    ]);
    $this->addCommentOnTable ( '{{%auth_item}}', '权限' );
    $this->addForeignKey ( 'fk-auth_item-ruleId', '{{%auth_item}}', 'ruleId', '{{%auth_rule}}', 'id', 'SET NULL', 'CASCADE' );
    $this->createIndex ( 'idx-auth_item-type', '{{%auth_item}}', 'type' );

    $this->createTable ( '{{%auth_item_child}}', [
        'parent' => $this->string ( 64 )->notNull ()->comment ( '上级' ),
        'child' => $this->string ( 64 )->notNull ()->comment ( '下级' ),
        'sort' => $this->smallInteger ()->defaultValue ( 0 )->comment ( '排序' ),
        'PRIMARY KEY ([[parent]], [[child]])'
    ]);
    $this->addCommentOnTable ( '{{%auth_item_child}}', '子权限' );
    $this->addForeignKey ( 'fk-auth_item_child-parent', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE' );
    $this->addForeignKey ( 'fk-auth_item_child-child', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE' );

    $this->createTable ( '{{%auth_assignment}}', [
        'itemId' => $this->string ( 64 )->notNull ()->comment ( '权限' ),
        'userId' => $this->string ( 64 )->notNull ()->comment ( '用户ID' ),
        'createdAt' => $this->dateTime ()->comment ( '添加时间' ),
        'PRIMARY KEY ([[itemId]], [[userId]])'
    ]);
    $this->addCommentOnTable ( '{{%auth_assignment}}', '授权' );
    $this->addForeignKey ( 'fk-auth_assignment-item_name', '{{%auth_assignment}}', 'itemId', '{{%auth_item}}', 'id', 'CASCADE', 'CASCADE' );
  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropTable ( '{{%auth_assignment}}' );
    $this->dropTable ( '{{%auth_rule}}' );
    $this->dropTable ( '{{%auth_item_children}}' );
    $this->dropTable ( '{{%auth_item}}' );
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
   * echo "m201121_084512_create_auth_tables cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
