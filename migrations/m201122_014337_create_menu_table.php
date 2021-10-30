<?php
use yii\db\Migration;
/**
 * Handles the creation of table `{{%menu}}`.
 */
class m201122_014337_create_menu_table extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
    $this->createTable( '{{%menu}}', [
        'id' => $this->primaryKey(),
        'pid' => $this->integer()->notNull()->comment( '父菜单ID' ),
        'name' => $this->string( 64 )->notNull()->comment( '菜单名' ),
        'url' => $this->string( 128 )->notNull()->defaultValue( '#' )->comment( '链接' ),
        'isOuter' => $this->boolean()->defaultValue( 0 )->comment( '是否外部链接::0:否|1:是' ),
        'requireAuth' => $this->boolean()->defaultValue( 1 )->comment( '需要鉴权::0:不需要|1:需要' ),
        'icon' => $this->string( 64 )->null()->comment( 'ICON' ),
        'app' => $this->string( 64 )->notNull()->defaultValue( 'core' )->comment( '所属APP::后台或插件的Id' ),
        'sort' => $this->smallInteger()->defaultValue( 0 )->comment( '排序' )
    ], $tableOptions );
    $this->addCommentOnTable( '{{%menu}}', '菜单' );
    $this->createTable( '{{%navigation}}', [
        'id' => $this->primaryKey(),
        'pid' => $this->integer()->notNull()->comment( '父导航D' ),
        'name' => $this->string( 64 )->notNull()->comment( '导航名' ),
        'intro' => $this->string(128)->null()->comment('介绍'),
        'url' => $this->string( 128 )->notNull()->defaultValue( '#' )->comment( '地址::可以是内部和外部地址' ),
        'isOuter' => $this->boolean()->defaultValue( 0 )->comment( '是否外部链接::0:否|1:是' ),
        'requireAuth' => $this->boolean()->defaultValue( 0 )->comment( '需要登录::0:不需要|1:需要' ),
        'icon' => $this->string( 64 )->null()->comment( 'ICON' ),
        'app' => $this->string( 64 )->notNull()->defaultValue( 'frontend' )->comment( '所属APP::前台或后台或插件的Id' ),
        'sort' => $this->smallInteger()->defaultValue( 0 )->comment( '排序' )
    ], $tableOptions );
    $this->addCommentOnTable( '{{%navigation}}', '前端导航' );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->dropTable( '{{%menu}}' );
    $this->dropTable( '{{%navigation}}' );

  }
}
