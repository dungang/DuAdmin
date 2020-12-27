<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_block}}`.
 */
class m201125_132002_create_page_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->createTable('{{%page_block}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->comment("名称"),
            'widget' => $this->string()->notNull()->comment('小部件'),
            'sourceApp' => $this->string(128)->notNull()->comment('来源App'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%page_block}}','首页块');
        
        $this->createTable('{{%page_block_data}}', [
            'id' => $this->primaryKey(),
            'blockId' => $this->integer()->notNull()->comment('块ID'),
            'title' => $this->string(64)->null()->comment("标题"),
            'intro' => $this->text()->null()->comment("说明"),
            'url' => $this->string(128)->comment('地址'),
            'isOuterUrl' => $this->boolean()->defaultValue(false)->comment('是外部地址::1:是|0:否'),
            'urlText' => $this->string(128)->comment('地址标题'),
            'filter' => $this->string(255)->null()->comment('过滤条件::如 name=duadmin&id=du 使用queryString格式'),
            'size' => $this->smallInteger()->defaultValue(1)->comment('数量'),
            'orderBy' => $this->string(32)->null()->comment('显示排序::如 id DESC, sort ASC'),
            'style' => $this->string(255)->null()->comment('样式'),
            'options' => $this->string(255)->null()->comment('元素选项::yii框架类似选项使用queryString设置'),
            'enableCache' => $this->boolean()->defaultValue(false)->comment('是否缓存::1:是|0:否'),
            'expiredAt' => $this->dateTime()->null()->comment('缓存过期时间::0和空表示永久缓存'),
            'sort' => $this->smallInteger()->defaultValue(0)->comment('排序'),
        ]);
        $this->addCommentOnTable('{{%page_block_data}}','首页块数据');
        $this->createIndex("fk-page_block_data-blockId","{{%page_block_data}}", ['blockId']);
        
  
        $this->insert("{{%page_block}}",[
            'name' => 'DuAdmin巨幕',
            'widget' => 'DuAdmin\Widgets\JumbotronBlock',
            'sourceApp' => 'core',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ]);
        $this->insert("{{%page_block}}",[
            'name' => '前端联系我们',
            'widget' => 'Frontend\Widgets\ContactBlock',
            'sourceApp' => 'frontend',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ]);
        $this->insert("{{%page_block_data}}", [
            'blockId' => 1,
            'title' => 'Hello DuAdmin!',
            'intro' => 'For My Best Friends.',
            'url' => 'index',
            'urlText' => '<i class="fa fa-plane"></i> Get started with DuAdmin',
            'size' => 5
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_block}}');
        $this->dropTable('{{%page_block_data}}');
    }
}
