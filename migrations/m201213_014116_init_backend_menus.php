<?php

use DuAdmin\Helpers\InstallerHelper;
use yii\db\Migration;

/**
 * Class m201225_014116_init_backend_menus
 */
class m201213_014116_init_backend_menus extends Migration {

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp() {

        InstallerHelper::installMenus( [
            [
                'name' => '看板',
                'url'  => 'default/index',
                'icon' => 'fa fa-dashboard',
                'sort' => 1 ],
            [
                'name'     => '系统管理',
                'url'      => '#',
                'icon'     => 'fa fa-desktop',
                'sort'     => 1001,
                'children' => [
                    [
                        'name' => '管理员',
                        'url'  => 'administrator/index',
                        'icon' => 'fa fa-user' ],
                    [
                        'name' => '角色',
                        'url'  => 'auth-role/index',
                        'icon' => 'fa fa-flag' ],
                    [
                        'name' => '权限',
                        'url'  => 'auth-permission/index',
                        'icon' => 'fa fa-lock' ],
                    [
                        'name' => '规则',
                        'url'  => 'auth-rule/index',
                        'icon' => 'fa fa-key' ],
                    [
                        'name' => '后端菜单',
                        'url'  => 'menu/index',
                        'icon' => 'fa fa-bars' ],
                    [
                        'name' => '前端导航',
                        'url'  => 'navigation/index',
                        'icon' => 'fa fa-anchor' ],
                    [
                        'name' => '操作日志',
                        'url'  => 'action-log/index',
                        'icon' => 'fa fa-road' ] ] ],
            [
                'name'     => '系统配置',
                'url'      => '#',
                'icon'     => 'fa fa-gears',
                'sort'     => 1100,
                'children' => [
                    [
                        'name' => '设置',
                        'url'  => 'setting/index',
                        'icon' => 'fa fa-cog' ],
                    [
                        'name' => '字典',
                        'url'  => 'dict-type/index',
                        'icon' => 'fa fa-book' ],
                    [
                        'name' => '插件',
                        'url'  => 'addon/index',
                        'icon' => 'fa fa-plug' ],
                    [
                        'name' => '定时任务',
                        'url'  => 'cron/index',
                        'icon' => 'fa fa-tasks' ] ] ] ], 0, 'core' );

        InstallerHelper::installNavigations( [
            [
                'name'    => 'Gitee',
                'url'     => 'https://gitee.com/dungang/DuAdmin',
                'isOuter' => 1 ],
            [
                'name'    => 'GitHub',
                'url'     => 'https://github.com/dungang/DuAdmin',
                'isOuter' => 1 ],
            [
                'name' => '联系我们',
                'url'  => 'contact-us' ],
            [
                'name' => '关于我们',
                'url'  => 'about-us' ] ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown() {

        echo "m201225_014116_init_backend_menus cannot be reverted.\n";
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
     * echo "m201225_014116_init_backend_menus cannot be reverted.\n";
     *
     * return false;
     * }
     */
}
