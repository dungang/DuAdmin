<?php
use yii\db\Migration;
use DuAdmin\Helpers\InstallerHelper;

/**
 * Class m201225_014116_init_backend_menus
 */
class m201225_014116_init_backend_menus extends Migration
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
                        'name' => 'Blocks',
                        'url' => 'block/index',
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
                        'name' => 'Locale and Language',
                        'url' => 'locale/index',
                        'icon' => 'fa fa-language'
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
        ],0,'core',true);
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
