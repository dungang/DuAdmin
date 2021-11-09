<?php

use DuAdmin\Db\DuAdminMigration;
use DuAdmin\Helpers\InstallerHelper;

/**
 * Class m201121_090115_create_dict_tables
 */
class m201121_090115_create_dict_tables extends DuAdminMigration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dict_type}}', [
            'id'        => $this->primaryKey(),
            'dictName'  => $this->string(64)->notNull()->comment('字典名'),
            'dictType'  => $this->string(64)->notNull()->comment('字典类型'),
            'status'    => $this->boolean()->defaultValue(true)->comment('状态::0:不可用|1:可用'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间')
        ]);
        $this->createIndex('idx-dictType', '{{%dict_type}}', 'dictType');
        $this->addCommentOnTable('{{%dict_type}}', '系统字典');
        $this->createTable('{{%dict_data}}', [
            'id'        => $this->primaryKey(),
            'dictLabel' => $this->string(64)->notNull()->comment('字典标签'),
            'dictValue' => $this->string(255)->notNull()->comment('字典键值'),
            'dictType'  => $this->string(64)->notNull()->comment('字典类型'),
            'listCss'   => $this->string(64)->null()->comment('显示样式'),
            'intro'     => $this->string(255)->null()->comment('介绍'),
            'isDefault' => $this->boolean()->defaultValue(false)->comment('是否默认值::0:否|1:是'),
            'sort'      => $this->smallInteger()->defaultValue(0)->comment('排序'),
            'status'    => $this->boolean()->defaultValue(true)->comment('状态::0:不可用|1:可用'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间')
        ]);
        $this->createIndex('idx-dictType', '{{%dict_data}}', 'dictType');
        $this->addCommentOnTable('{{%dict_data}}', '系统字典数据');

        InstallerHelper::InstallDict('yes_or_no', '是否', [
            ['dictLabel' => '否', 'dictValue' => 0],
            ['dictLabel' => '是', 'dictValue' => 1],
        ]);
        InstallerHelper::InstallDict('online_status', '在线状态', [
            ['dictLabel' => '下线', 'dictValue' => 0],
            ['dictLabel' => '上线', 'dictValue' => 1],
        ]);
        InstallerHelper::InstallDict('online_status', '激活状态', [
            ['dictLabel' => '未激活', 'dictValue' => 0],
            ['dictLabel' => '以激活', 'dictValue' => 1],
        ]);
        InstallerHelper::InstallDict('setting_category', '系统配置分类', [
            ['dictLabel' => '基本设置', 'dictValue' => 'base'],
            ['dictLabel' => '邮件服务', 'dictValue' => 'email'],
            ['dictLabel' => '开放功能', 'dictValue' => 'open-feature'],
            ['dictLabel' => '邮件服务', 'dictValue' => 'email'],
        ]);
        InstallerHelper::InstallDict('system_languages', '系统语言', [
            ['dictLabel' => '中文', 'dictValue' => 'zh-CN'],
            ['dictLabel' => '英文', 'dictValue' => 'en-US'],
        ]);
        InstallerHelper::InstallDict('system_storage', '系统存储驱动', [
            ['dictLabel' => '本地存储', 'dictValue' => '\DuAdmin\Storage\LocalDriver']
        ]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%dict_type}}');
        $this->dropTable('{{%dict_data}}');
    }
}
