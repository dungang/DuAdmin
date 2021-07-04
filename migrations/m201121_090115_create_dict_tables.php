<?php

use DuAdmin\Db\DuAdminMigration;
use DuAdmin\Helpers\InstallerHelper;

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
        $this->createTable( '{{%dict_type}}', [
            'id'        => $this->primaryKey(),
            'dictName'  => $this->string( 64 )->notNull()->comment( '字典名' ),
            'dictType'  => $this->string( 64 )->notNull()->comment( '字典类型' ),
            'status'    => $this->boolean()->defaultValue( true )->comment( '状态::0:不可用|1:可用' ),
            'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
            'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
            ], $tableOptions );
        $this->createIndex( 'idx-dictType', '{{%dict_type}}', 'dictType' );
        $this->addCommentOnTable( '{{%dict_type}}', '系统字典' );
        $this->createTable( '{{%dict_data}}', [
            'id'        => $this->primaryKey(),
            'dictLabel' => $this->string( 64 )->notNull()->comment( '字典标签' ),
            'dictValue' => $this->string( 255 )->notNull()->comment( '字典键值' ),
            'dictType'  => $this->string( 64 )->notNull()->comment( '字典类型' ),
            'listCss'   => $this->string( 64 )->null()->comment( '显示样式' ),
            'isDefault' => $this->boolean()->defaultValue( false )->comment( '是否默认值::0:否|1:是' ),
            'sort'      => $this->smallInteger()->defaultValue( 0 )->comment( '排序' ),
            'status'    => $this->boolean()->defaultValue( true )->comment( '状态::0:不可用|1:可用' ),
            'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
            'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
            ], $tableOptions );
        $this->createIndex( 'idx-dictType', '{{%dict_data}}', 'dictType' );
        $this->addCommentOnTable( '{{%dict_data}}', '系统字典数据' );
        $this->insert( "{{%dict_type}}", [
            'dictName'  => '是否',
            'dictType'  => 'yes_or_no',
            'status'    => 1,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' )
        ] );
        $this->insert( "{{%dict_type}}", [
            'dictName'  => '系统配置分类',
            'dictType'  => 'setting_category',
            'status'    => 1,
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' )
        ] );
        $this->batchInsert( "{{%dict_data}}", [
            'dictLabel',
            'dictValue',
            'dictType',
            'listCss',
            'isDefault',
            'sort',
            'status',
            'createdAt',
            'updatedAt'
            ], [
            [
                '是',
                '1',
                'yes_or_no',
                '',
                1,
                1,
                1,
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s' )
            ],
            [
                '否',
                '0',
                'yes_or_no',
                '',
                0,
                1,
                1,
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s' )
            ],
            [
                '基本设置',
                'base',
                'setting_category',
                '',
                0,
                1,
                1,
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s' )
            ],
            [
                '邮件服务',
                'email',
                'setting_category',
                '',
                0,
                1,
                1,
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s' )
            ],
            [
                '开放功能',
                'open-feature',
                'setting_category',
                '',
                0,
                1,
                1,
                date( 'Y-m-d H:i:s' ),
                date( 'Y-m-d H:i:s' )
            ]
        ] );

        InstallerHelper::InstallDict( 'system_storage', '系统存储驱动', [
            [ 'dictLabel' => '本地存储', 'dictValue' => '\DuAdmin\Storage\LocalDriver' ]
        ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->dropTable( '{{%dict_type}}' );
        $this->dropTable( '{{%dict_data}}' );
    }

}
