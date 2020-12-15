<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addon_navigation}}`.
 */
class m201213_020534_create_addon_navigation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addon_navigation}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer()->notNull()->defaultValue(0)->comment('上级导航'),
            'name' => $this->string(64)->notNull()->comment('名称'),
            'url' => $this->string(255)->notNull()->defaultValue('#')->comment('地址::可以是内部和外部地址'),
            'app' => $this->string(32)->notNull()->defaultValue('frontend')->comment('所属APP::前台或后台或插件的Id'),
            'sort' => $this->smallInteger()->defaultValue(1)->comment('排序::从小到大顺序'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%addon_navigation}}','前端导航');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%addon_navigation}}');
    }
}
