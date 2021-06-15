<?php
use DuAdmin\Db\DuAdminMigration;

/**
 * Class m201121_090115_create_dict_tables
 */
class m201121_090115_create_dict_tables extends DuAdminMigration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {
    $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
    $this->createTable ( '{{%dict_type}}', [
        'id' => $this->primaryKey (),
        'dict_name' => $this->string ( 64 )->notNull ()->comment ( '字典名' ),
        'dict_type' => $this->string ( 64 )->notNull ()->comment ( '字典类型' ),
        'status' => $this->boolean ()->defaultValue ( true )->comment ( '状态::0:不可用|1:可用' ),
        'createdAt' => $this->dateTime ()->null ()->comment ( '添加时间' ),
        'updatedAt' => $this->dateTime ()->null ()->comment ( '更新时间' )
    ], $tableOptions );
    $this->createIndex ( 'idx-dict_type', '{{%dict_type}}', 'dict_type' );
    $this->addCommentOnTable ( '{{%dict_type}}', '系统字典' );
    $this->createTable ( '{{%dict_data}}', [
        'id' => $this->primaryKey (),
        'dict_label' => $this->string ( 64 )->notNull ()->comment ( '字典标签' ),
        'dict_value' => $this->string ( 64 )->notNull ()->comment ( '字典键值' ),
        'dict_type' => $this->string ( 64 )->notNull ()->comment ( '字典类型' ),
        'list_css' => $this->string ( 64 )->null ()->comment ( '显示样式' ),
        'is_default' => $this->boolean ()->defaultValue ( false )->comment ( '是否默认值::0:否|1:是' ),
        'sort' => $this->smallInteger ()->defaultValue ( 0 )->comment ( '排序' ),
        'status' => $this->boolean ()->defaultValue ( true )->comment ( '状态::0:不可用|1:可用' ),
        'createdAt' => $this->dateTime ()->null ()->comment ( '添加时间' ),
        'updatedAt' => $this->dateTime ()->null ()->comment ( '更新时间' )
    ], $tableOptions );
    $this->createIndex ( 'idx-dict_type', '{{%dict_data}}', 'dict_type' );
    $this->addCommentOnTable ( '{{%dict_data}}', '系统字典数据' );
    $this->insert ( "{{dict_type}}", [
        'dict_name' => '是否',
        'dict_type' => 'yes_or_no',
        'status' => 1,
        'created_at' => date ( 'Y-m-d H:i:s' ),
        'upated_at' => date ( 'Y-m-d H:i:s' )
    ] );
    $this->batchInsert ( "{{dict_data}}", [
        'dict_label',
        'dict_value',
        'dict_type',
        'list_css',
        'is_default',
        'sort',
        'status',
        'created_at',
        'updated_at'
    ], [
        [
            '是',
            '1',
            'yes_or_no',
            '',
            1,
            1,
            1,
            date ( 'Y-m-d H:i:s' ),
            date ( 'Y-m-d H:i:s' )
        ],
        [
            '否',
            '0',
            'yes_or_no',
            '',
            0,
            1,
            1,
            date ( 'Y-m-d H:i:s' ),
            date ( 'Y-m-d H:i:s' )
        ]
    ] );
  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {
    $this->dropTable ( '{{%dict_type}}' );
    $this->dropTable ( '{{%dict_data}}' );
  }
}
