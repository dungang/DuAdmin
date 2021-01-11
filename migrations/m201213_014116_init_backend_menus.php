<?php

use yii\db\Migration;
use DuAdmin\Helpers\InstallerHelper;

/**
 * Class m201225_014116_init_backend_menus
 */
class m201213_014116_init_backend_menus extends Migration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        InstallerHelper::installMenus([
            [
                'name' => 'Dashboard',
                'url' => 'default/index',
                'icon' => 'fa fa-dashboard',
                'sort' => 1
            ],
            [
                'name' => 'Marketing',
                'url' => '#',
                'icon' => 'fa fa-gg-circle',
                'sort' => 900,
                'children' => [
                    [
                        'name' => 'Page Blocks',
                        'url' => 'page-block-data/index',
                        'icon' => 'fa fa-clone'
                    ]
                ]
            ],
            [
                'name' => 'System',
                'url' => '#',
                'icon' => 'fa fa-desktop',
                'sort' => 1001,
                'children' => [
                    [
                        'name' => 'Administrator',
                        'url' => 'administrator/index',
                        'icon' => 'fa fa-user'
                    ],

                    [
                        'name' => 'Roles',
                        'url' => 'auth-role/index',
                        'icon' => 'fa fa-flag'
                    ],
                    [
                        'name' => 'Permissions',
                        'url' => 'auth-permission/index',
                        'icon' => 'fa fa-lock'
                    ],
                    [
                        'name' => 'Rules',
                        'url' => 'auth-rule/index',
                        'icon' => 'fa fa-key'
                    ],
                    [
                        'name' => 'Menus',
                        'url' => 'menu/index',
                        'icon' => 'fa fa-bars'
                    ],
                    [
                        'name' => 'Navigation',
                        'url' => 'navigation/index',
                        'icon' => 'fa fa-anchor'
                    ],
                    [
                        'name' => 'Action Logs',
                        'url' => 'action-log/index',
                        'icon' => 'fa fa-road'
                    ]
                ]
            ],
            [
                'name' => 'Configurations',
                'url' => '#',
                'icon' => 'fa fa-gears',
                'sort' => 1100,
                'children' => [
                    [
                        'name' => 'Settings',
                        'url' => 'setting/index',
                        'icon' => 'fa fa-cog'
                    ],
                    [
                        'name' => 'Addons',
                        'url' => 'addon/index',
                        'icon' => 'fa fa-plug'
                    ],
                    [
                        'name' => 'Pretty Url',
                        'url' => 'pretty-url/index',
                        'icon' => 'fa fa-location-arrow'
                    ],
                    [
                        'name' => 'Cron Jobs',
                        'url' => 'cron/index',
                        'icon' => 'fa fa-tasks'
                    ]
                ]
            ]
        ], 0, 'core', true);

        InstallerHelper::installNavigations([
            ['name' => 'Gitee', 'url' => 'https://gitee.com/dungang/DuAdmin', 'isOuter' => 1],
            ['name' => 'GitHub', 'url' => 'https://github.com/dungang/DuAdmin', 'isOuter' => 1],
            ['name' => '联系我们', 'url' => 'contact-us'],
            ['name' => '关于我们', 'url' => 'about-us']
        ]);

        InstallerHelper::installPermissions([
            [
                'id' => 'administrator/index',
                'name' => '管理员',
                'children' => [
                    [
                        'id' => 'administrator/roles',
                        'name' => '分配管理员角色',
                    ],
                    [
                        'id' => 'administrator/view',
                        'name' => '查看管理员',
                    ],
                    [
                        'id' => 'administrator/update',
                        'name' => '更新管理员',
                    ],
                    [
                        'id' => 'administrator/create',
                        'name' => '添加管理员',
                    ],
                ]

            ]
        ]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {
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
