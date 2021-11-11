<?php

use DuAdmin\Helpers\InstallerHelper;
use Console\components\Migration;

/**
 * Class m210111_132217_init_cms_permissions
 */
class m210111_132217_cms_init_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        InstallerHelper::installAddonPermission("addon-cms", "内容模块管理");
        InstallerHelper::installPermissionCRUDShortcut("文章分类", "cms/category", "addon-cms");
        InstallerHelper::installPermissions([
            [
                'id' => 'cms/category/sorts',
                'name' => '更新文章分类排序'
            ]
        ], 'cms/category/update');
        InstallerHelper::installPermissionCRUDShortcut("文章", "cms/post", "addon-cms");
        InstallerHelper::installPermissionCRUDShortcut("轮播图", "cms/flash", "addon-cms");
        InstallerHelper::installPermissionCRUDShortcut("单页", "cms/page", "addon-cms");
        InstallerHelper::installPermissions([
            [
                'id' => 'cms/live-editor/index',
                'name' => '在线编辑器'
            ],
            [
                'id' => 'cms/live-editor/save',
                'name' => '编辑器保存'
            ],
            [
                'id' => 'cms/setting',
                'name' => '内容管理设置'
            ]
        ], 'cms/page/update');
        InstallerHelper::installPermissionCRUDShortcut("友情链接", "cms/friend-link", "addon-cms");
        InstallerHelper::installPermissionCRUDShortcut("广告位", "cms/adv-block", "addon-cms");

        InstallerHelper::InstallDict('cms_page_show_mode', '页面显示模式', [
            ['dictLabel' => '完整显示', 'dictValue' => 'full'],
            ['dictLabel' => '只显示内容', 'dictValue' => 'content'],
            ['dictLabel' => '不显示头部', 'dictValue' => 'nohead'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        InstallerHelper::uninstallMenus("addon-cms");
        InstallerHelper::uninstallPermissions("addon-cms");
        InstallerHelper::uninstallSetting("addon-cms");
        
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
