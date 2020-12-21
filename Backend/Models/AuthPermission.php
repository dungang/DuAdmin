<?php
namespace Backend\Models;

use DuAdmin\Rbac\Item;

/**
 * 系统权限
 * 每个权限最多有个权限类型的父节点
 * 一个权限不要出现有2个直系父节点的出现。
 * Yii的rbac本身是支持多对多的关系，灵活的优点，也带来了管理的复杂度，
 * 权限管理的界面设计很比较难做到易用。
 * 不是树形结构，更像一张网的结构
 * 本人研究过mdmsoft/yii2-admin https://github.com/mdmsoft/yii2-admin
 * 自己的之前的项目也尝试完全按照多对多的可能性管理，管理的时候，分配权限的时候界面的展现太不直观了。
 * 所以为什么yii2的rbac的管理扩展很少的原因吧。
 * 本项目利用灵活性，减少灵活性。
 *
 * @author dungang
 *        
 * @property string|integer $pid
 * @property string $roleId;
 */
class AuthPermission extends AuthItem
{

    public $pid;
    
    
    public function getRoleId(){
        return $this->id;
    }
    
    public function setRoleId($roleId){
        $this->id = $roleId;
    }
    

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            'pid',
            'string'
        ];
        return $rules;
    }

    public function init()
    {
        $this->type = Item::TYPE_PERMISSION;

        // 这个事件比较特殊，如果要绑定只在模型内绑定
        // 模型实例化绑定就迟到
        // 绑定的方式可以是直接监听或者通过行为绑定了
        $this->on(AuthItem::EVENT_AFTER_FIND, [
            $this,
            'findPermissionPid'
        ]);
    }

    public function findPermissionPid()
    {
        $this->pid = $this->findTypePermissionPid();
    }

    /**
     * 获取本节点最多一个同类型节点的parent
     */
    public function findTypePermissionPid()
    {
        $t1 = AuthItemChild::tableName();
        $t2 = AuthItem::tableName();
        return AuthItemChild::find()->innerJoin($t2, $t1 . ".parent=" . $t2 . ".id")
            ->where([
            $t2 . ".type" => $this->type,
            $t1 . ".child" => $this->id
        ])
            ->select('parent')
            ->scalar();
    }
}

