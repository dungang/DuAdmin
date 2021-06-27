<?php
use yii\db\Migration;
/**
 * Class m210627_081912_create_generator_tables
 */
class m210627_081912_create_generator_tables extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
    $this->createTable( '{{%gen_table}}', [
        'id' => $this->primaryKey(),
        'tableName' => $this->string( 128 )->comment( '表名' ),
        'tableComment' => $this->string( 128 )->comment( '表注释' ),
        'modelNamespace' => $this->string( 128 )->comment( '模型命名空间' ),
        'modelName' => $this->string( 128 )->comment( '模型名称' ),
        'modelBaseName' => $this->string( 128 )->comment( '模型基类' ),
        'activeQueryBaseName' => $this->string( 128 )->comment( '查询模型基类' ),
        'dbConnectionId' => $this->string( 128 )->defaultValue( 'db' )->comment( '数据库链接ID' ),
        'enableSearchModel' => $this->boolean()->defaultValue( false )->comment( '是否生成搜索模型::0:否|1:是' ),
        'enableI18n' => $this->boolean()->defaultValue( true )->comment( '是否支持国际化::0:否|1:是' ),
        'backendControllerNamespace' => $this->string( 128 )->comment( '后台控制器命名空间' ),
        'frontendControllerNamespace' => $this->string( 128 )->comment( '前台控制器命名空间' ),
        'apiControllerNamespace' => $this->string( 128 )->comment( 'API控制器命名空间' ),
        'backendControllerBase' => $this->string( 128 )->comment( '后台控制器基类' ),
        'frontendControllerBase' => $this->string( 128 )->comment( '前台控制器基类' ),
        'apiControllerBase' => $this->string( 128 )->comment( 'API控制器基类' ),
        'controllerName' => $this->string( 128 )->comment( '控制器名称' ),
        'backendViewPath' => $this->string( 128 )->comment( '后台控制器视图路径' ),
        'frontendViewPath' => $this->string( 128 )->comment( '前台控制器视图路径' ),
        'backendListView' => $this->string( 128 )->comment( '后台控制器列表小部件' ),
        'frontendistView' => $this->string( 128 )->comment( '前台控制器列表小部件' ),
        'backendActions' => $this->string( 128 )->comment( '后台控制器的行为清单' ),
        'frontendActions' => $this->string( 128 )->comment( '前台控制器的行为清单' ),
        'modalDailogSize' => $this->string( 16 )->comment( '模态框大小::def:默认窗口|sm:小窗口|lg:大窗口' ),
        'enableUserData' => $this->boolean()->defaultValue( false )->comment( '当前用户的数据::0:否|1:是' ),
        'enablePjax' => $this->boolean()->defaultValue( false )->comment( '是否使用Pjax::0:否|1:是' ),
        'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
        'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
    ], $tableOptions );
    $this->createIndex( 'idx-tableName', '{{%gen_table}}', 'tableName' );
    $this->addCommentOnTable( '{{%gen_table}}', '生成表' );
    $this->createTable( '{{%gen_table_column}}', [
        'id' => $this->primaryKey(),
        'tableId' => $this->integer()->notNull()->comment( '表Id' ),
        'field' => $this->string( 64 )->notNull()->comment( '字段' ),
        'comment' => $this->string( 64 )->notNull()->comment( '注释' ),
        'tips' => $this->string( 64 )->comment( '提示' ),
        'enableRequired' => $this->boolean()->defaultValue( true )->comment( '是否列表必填字段::0:否|1:是' ),
        'enableList' => $this->boolean()->defaultValue( true )->comment( '是否列表显示字段::0:否|1:是' ),
        'enableQuery' => $this->boolean()->defaultValue( true )->comment( '是否查询字段::0:否|1:是' ),
        'enableSearch' => $this->boolean()->defaultValue( false )->comment( '是否搜索字段::0:否|1:是' ),
        'sortable' => $this->string( 8 )->comment( '排序::desc:从大到小|asc:从小到大' ),
        'widgetType' => $this->string( 64 )->comment( '小部件' ),
        'dictType' => $this->string( 64 )->comment( '字典类型' ),
        'sort' => $this->smallInteger()->defaultValue( 1 )->comment( '排序' ),
        'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
        'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
    ], $tableOptions );
    $this->createIndex( 'idx-tableId', '{{%gen_table_column}}', 'tableId' );
    $this->addCommentOnTable( '{{%gen_table_column}}', '表字段' );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    echo "m210627_081912_create_generator_tables cannot be reverted.\n";
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
   * echo "m210627_081912_create_generator_tables cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
