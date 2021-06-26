<?php
use DuAdmin\Helpers\InstallerHelper;
use yii\db\Migration;
/**
 * Class m210111_132113_init_permissions
 */
class m210111_132113_init_permissions extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    InstallerHelper::installPermissions( [
        [
            'id' => 'administrator',
            'name' => '管理员管理',
            'children' => [
                [
                    'id' => 'administrator/index',
                    'name' => '管理员列表',
                    'children' => [
                        [
                            'id' => 'administrator/view',
                            'name' => '查看管理员'
                        ]
                    ]
                ],
                [
                    'id' => 'administrator/create',
                    'name' => '添加管理员'
                ],
                [
                    'id' => 'administrator/update',
                    'name' => '更新管理员'
                ],
                [
                    'id' => 'administrator/delete',
                    'name' => '删除管理员'
                ],
                [
                    'id' => 'administrator/roles',
                    'name' => '分配管理员角色'
                ]
            ]
        ],
        [
            'id' => 'auth-permission',
            'name' => '权限管理',
            'children' => [
                [
                    'id' => 'auth-permission/index',
                    'name' => '权限列表',
                    'children' => [
                        [
                            'id' => 'auth-permission/view',
                            'name' => '查看权限'
                        ]
                    ]
                ],
                [
                    'id' => 'auth-permission/create',
                    'name' => '添加权限',
                    'children' => [
                        [
                            'id' => 'auth-permission/batch-create',
                            'name' => '批量添加权限'
                        ]
                    ]
                ],
                [
                    'id' => 'auth-permission/update',
                    'name' => '更新权限',
                    'children' => [
                        [
                            'id' => 'auth-permission/batch-update',
                            'name' => '批量更新权限'
                        ],
                        [
                            'id' => 'auth-permission/sorts',
                            'name' => '更新权限排序'
                        ]
                    ]
                ],
                [
                    'id' => 'auth-permission/delete',
                    'name' => '删除权限'
                ]
            ]
        ]
    ] );
    InstallerHelper::installPermissionCRUDShortcut( "角色", "auth-role" );
    InstallerHelper::installPermissions( [
        [
            'id' => 'auth-role/sorts',
            'name' => '更新角色排序'
        ]
    ], 'auth-role/update' );
    InstallerHelper::installPermissionCRUDShortcut( "权限规则", "auth-rule" );
    InstallerHelper::installPermissionCRUDShortcut( "菜单", "menu" );
    InstallerHelper::installPermissions( [
        [
            'id' => 'menu/sorts',
            'name' => '更新菜单排序'
        ]
    ], 'menu/update' );
    InstallerHelper::installPermissionCRUDShortcut( "地址美化", "pretty-url" );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    echo "m210111_132113_init_permissions cannot be reverted.\n";
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
   * echo "m210111_132113_init_permissions cannot be reverted.\n";
   *
   * return false;
   * }
   */
}