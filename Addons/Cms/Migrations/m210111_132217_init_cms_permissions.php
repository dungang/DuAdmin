<?php

use DuAdmin\Helpers\InstallerHelper;
use yii\db\Migration;

/**
 * Class m210111_132217_init_cms_permissions
 */
class m210111_132217_init_cms_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        InstallerHelper::installPermissionCRUDShortcut("文章分类", "cms/category");
        InstallerHelper::installPermissions([
            [
                'id' => 'cms/category/sorts',
                'name' => '更新文章分类排序'
            ]
        ], 'cms/category/update');
        InstallerHelper::installPermissionCRUDShortcut("文章", "cms/post");
        InstallerHelper::installPermissionCRUDShortcut("轮播图", "cms/flash");
        InstallerHelper::installPermissionCRUDShortcut("单页", "cms/page");
        InstallerHelper::installPermissionCRUDShortcut("友情链接", "cms/friend-link");
        InstallerHelper::installPermissionCRUDShortcut("广告位", "cms/adv-block");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210111_132217_init_cms_permissions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210111_132217_init_cms_permissions cannot be reverted.\n";

        return false;
    }
    */
}