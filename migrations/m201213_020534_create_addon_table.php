<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addon_navigation}}`.
 */
class m201213_020534_create_addon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addon}}', [
            'id' => $this->string(64),
            'name' => $this->string(64)->notNull()->comment('名称'),
            'intro' => $this->string(255)->null()->comment('简介'),
            'hasSetting' => $this->boolean()->notNull()->defaultValue(false)->comment('设置::0:无|1:有'),
            'hasBackend' => $this->boolean()->notNull()->defaultValue(false)->comment('后端::0:无|1:有'),
            'hasFrontend' => $this->boolean()->notNull()->defaultValue(false)->comment('前端::0:无|1:有'),
            'hasApi' => $this->boolean()->notNull()->defaultValue(false)->comment('API::0:无|1:有'),
            'type' => $this->string(64)->notNull()->defaultValue('component')->comment('类型'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%addon}}','插件');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%addon}}');
    }
}
