<?php
namespace app\backend\controllers;

use yii\helpers\ArrayHelper;
use app\backend\models\AuthRole;
use app\mmadmin\core\BackendController;
use app\backend\models\AuthGroup;
use app\backend\models\AuthPermission;
use app\backend\models\AuthItemChild;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class AuthRoleController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthRoleSearch',
                    'group_name' => 'backend'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'baseAttrs' => [
                    'type' => AuthRole::TYPE_ROLE
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthRole'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'baseAttrs' => [
                    'type' => AuthRole::TYPE_ROLE
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthRole'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'baseAttrs' => [
                    'type' => AuthRole::TYPE_ROLE
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthRole'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'baseAttrs' => [
                    'type' => AuthRole::TYPE_ROLE
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthRole'
                ]
            ]
        ];
    }

    /**
     * 授权
     *
     * @param string $name
     * @return string
     */
    public function actionPermission($name)
    {
        $model = AuthRole::findOne([
            'name' => $name
        ]);

        
        // 角色已经拥有的权限
        $authChildren = $model->getChildren()->all();
        //获取角色和权限的name属性
        $rights = ArrayHelper::getColumn($authChildren, "name");

        // 如果是是更新权限
        if ($permissions = \Yii::$app->request->post('permission')) {
            $perms = [];
            foreach($permissions as $perm) {
                $perm = trim($perm);
                if(!empty($perm)) {
                    $perms = array_merge($perms,explode(',',$perm));
                }
            }
            // array_diff 结果是包含在第一个数组，不包含在第二个数组
            $adds = array_diff($perms, $rights);
            $dels = array_diff($rights, $perms);
            \Yii::$app->db->beginTransaction();
            try {
                // 删除取消的权限
                if ($dels) {
                    AuthItemChild::deleteAll([
                        'parent' => $name,
                        'child' => $dels
                    ]);
                }
                // 添加新的权限
                $rows = array_map(function ($val) use ($name) {
                    return [
                        $name,
                        $val
                    ];
                }, $adds);
                //\yii\helpers\BaseVarDumper::dump($rows);die;
                \Yii::$app->db->createCommand()
                    ->batchInsert(AuthItemChild::tableName(), [
                        'parent',
                        'child'
                    ], $rows)
                    ->execute();
                \Yii::$app->db->getTransaction()->commit();
                \Yii::$app->session->setFlash("success", "权限更新成功！");
                \Yii::$app->cache->delete('rbac');
            } catch (\Exception $e) {
                \Yii::$app->db->getTransaction()->rollBack();
                \Yii::$app->session->setFlash("error", "更新失败，系统错误：" . $e->getCode());
            }
            return $this->redirect(\Yii::$app->request->url);
        }

        //根据item的分组获取对应的组的信息
        $item_group = AuthGroup::findOne(['name'=>$model->group_name]);

        //根据组的信息，是否是backend属性，获取对应的的全部组(is_backend相同)
        $groups = AuthGroup::allIdToName('name', 'title', ['is_backend'=>$item_group->is_backend]);

        //再根据backend相同的组，查找到权限和角色
        $items = AuthPermission::findAll(['group_name' => array_keys($groups)]);

        //获取的角色和权限，分成2棵树(zTree)
        $roles = [];
        $permissions = [];
        foreach ($items as $item) {
            $node = [
                'id'=>$item->name,
                'name'=>$item->description,
                'checked' => in_array($item->name,$rights)
            ];
            
            if ($item->type == AuthGroup::TYPE_PERMISSION) {
                $group = $item->group_name ?: 'other';
                if(empty($permissions[$group])) {
                    $permissions[$group] = [
                        'id'=>$group,
                        'name'=> $groups[$group]?:'其他',
                        'nocheck'=>true,
                        'children'=>[],
                    ];
                }
                $permissions[$group]['children'][] = $node;
            } else {
                $node['name'] = $item->name;
                if($item->name == $name) {
                    continue;
                }
                $roles[] = $node;
            }
        }

        //将已经授权的角色和权限分离
        $role_rights = [];
        $permission_rights = [];
        foreach($authChildren as $child) {
            if($child->type == AuthGroup::TYPE_PERMISSION) {
                $permission_rights[] = $child->name;
            } else {
                $role_rights[] = $child->name;
            }
        }

        return $this->render("permission", [
            'model' => $model,
            'role_rights' => $role_rights,
            'permission_rights'=> $permission_rights,
            'roles' => $roles,
            'permissions' => array_values($permissions),
        ]);
    }
}
