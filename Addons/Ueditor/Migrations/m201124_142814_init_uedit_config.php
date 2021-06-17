<?php

use yii\db\Migration;

/**
 * Class m201124_142814_init_uedit_config
 */
class m201124_142814_init_uedit_config extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //初始化配置参数
        $this->batchInsert('{{%setting}}',
            ['name','parent','title','value','valType','hint','category'],
            [
                ['ueditor.driver','system.editor.driver', '百度编辑器', '\Addons\Ueditor\Widget\Ueditor', 'STR','百度编辑器作为系统编辑器的配置选项',  'addon-ueditor'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%setting}}',['category'=>'addon-ueditor']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201124_142814_init_uedit_config cannot be reverted.\n";

        return false;
    }
    */
}
