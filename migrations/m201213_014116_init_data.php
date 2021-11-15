<?php

use DuAdmin\Helpers\InstallerHelper;
use yii\db\Migration;

/**
 * Class m201225_014116_init_data
 */
class m201213_014116_init_data extends Migration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {

        InstallerHelper::installMenus([
            [
                'name' => '看板',
                'url'  => 'default/index',
                'icon' => 'fa fa-dashboard',
                'sort' => 1
            ],
            [
                'name'     => '系统管理',
                'url'      => '#',
                'icon'     => 'fa fa-desktop',
                'sort'     => 1001,
                'children' => [
                    [
                        'name' => '管理员',
                        'url'  => 'administrator/index',
                        'icon' => 'fa fa-user'
                    ],
                    [
                        'name' => '角色',
                        'url'  => 'auth-role/index',
                        'icon' => 'fa fa-flag'
                    ],
                    [
                        'name' => '权限',
                        'url'  => 'auth-permission/index',
                        'icon' => 'fa fa-lock'
                    ],
                    [
                        'name' => '规则',
                        'url'  => 'auth-rule/index',
                        'icon' => 'fa fa-key'
                    ],
                    [
                        'name' => '后端菜单',
                        'url'  => 'menu/index',
                        'icon' => 'fa fa-bars'
                    ],
                    [
                        'name' => '前端导航',
                        'url'  => 'navigation/index',
                        'icon' => 'fa fa-anchor'
                    ],
                    [
                        'name' => '操作日志',
                        'url'  => 'action-log/index',
                        'icon' => 'fa fa-road'
                    ]
                ]
            ],
            [
                'name'     => '系统配置',
                'url'      => '#',
                'icon'     => 'fa fa-gears',
                'sort'     => 1100,
                'children' => [
                    [
                        'name' => '设置',
                        'url'  => 'setting/index',
                        'icon' => 'fa fa-cog'
                    ],
                    [
                        'name' => '字典',
                        'url'  => 'dict-type/index',
                        'icon' => 'fa fa-book'
                    ],
                    [
                        'name' => 'URL美化',
                        'url'  => 'pretty-url/index',
                        'icon' => 'fa fa-plug'
                    ],
                    [
                        'name' => '邮件模板',
                        'url'  => 'mail-template/index',
                        'icon' => 'fa fa-envelope'
                    ],
                    [
                        'name' => '插件',
                        'url'  => 'addon/index',
                        'icon' => 'fa fa-plug'
                    ],
                    [
                        'name' => '定时任务',
                        'url'  => 'cron/index',
                        'icon' => 'fa fa-tasks'
                    ]
                ]
            ]
        ], 0, 'core');

        InstallerHelper::installNavigations([
            [
                'name'     => '下载',
                'intro'    => 'DUAdmin下载地址',
                'url'      => '#',
                'requireAuth' => 0,
                'children' => [
                    [
                        'name'    => 'Gitee',
                        'url'     => 'https://gitee.com/dungang/DuAdmin',
                        'intro'   => 'DUAdmin的源码地址-码云地址',
                        'isOuter' => 1,
                        'requireAuth' => 0,
                    ],
                    [
                        'name'    => 'GitHub',
                        'url'     => 'https://github.com/dungang/DuAdmin',
                        'intro'   => 'DUAdmin的源码地址-Github',
                        'isOuter' => 1,
                        'requireAuth' => 0,
                    ],
                    [
                        'name'    => 'Demo',
                        'url'     => 'http://www.duadmin.com',
                        'intro'   => 'DUAdmin的Demo地址',
                        'isOuter' => 1,
                        'requireAuth' => 0,
                    ],
                ]
            ],
            [
                'name'     => '开源项目',
                'intro'    => '作者的其他开源项目',
                'url'      => '#',
                'requireAuth' => 0,
                'children' => [
                    [
                        'name'    => 'GeeTask',
                        'intro'   => 'GeeTask 极简项目管理',
                        'url'     => 'https://gitee.com/dungang/gee-task',
                        'isOuter' => 1,
                        'requireAuth' => 0,
                    ],
                    [
                        'name'    => 'Luck Lottery',
                        'intro'   => 'Luck Lottery 年会抽奖软件',
                        'url'     => 'https://github.com/dungang/lucky-lottery',
                        'isOuter' => 1,
                        'requireAuth' => 0,
                    ],
                ]
            ],
            [
                'name'  => '联系我们',
                'intro' => '了解DUAdmin的最好方式是联系我们',
                'url'   => 'contact-us',
                'requireAuth' => 0,
            ],
            [
                'name'  => '关于我们',
                'intro' => 'DUAdmin官方背书-关于我们',
                'url'   => 'about-us',
                'requireAuth' => 0,
            ]
        ]);

        InstallerHelper::installMailTemplate(
            'sys_register_verify_mail',
            '账户邮箱验证通知',
            '<p>Hello {username},</p>
            <p>Follow the link below to verify your email:</p>
            <p>{verifyLink}</p>',
            '{username} 账户，{verifyLink} 验证链接',
        );
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
