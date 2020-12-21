<?php
namespace Backend\Behaviors;

use yii\base\Behavior;
use Backend\Models\AuthItemChild;
use Backend\Models\AuthPermission;

/**
 * 管理auth_item 的关联关系
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-21
 */
class AuthItemSyncVirtualPidBehavior extends Behavior
{

    public function events()
    {
        return [
            AuthPermission::EVENT_AFTER_INSERT => 'createOne',
            AuthPermission::EVENT_AFTER_UPDATE => 'updateOne'
        ];
    }

    /**
     * 保存pid，实际上是建立在auth_item_child添加父子关系
     *
     * @param \yii\db\AfterSaveEvent $event
     */
    public function createOne($event)
    {
        if ($this->pid) {
            $this->createRelation($event->owner);
        }
    }

    /**
     * 保存pid，实际上是建立在auth_item_child添加父子关系
     *
     * @param \yii\db\AfterSaveEvent $event
     */
    public function updateOne($event)
    {
        /* @var AuthPermission $model */
        $model = $this->owner;
        $pid = $model->findTypePermissionPid();
        if (empty($pid) && ! empty($model->pid)) {
            $this->createRelation($model);
        } else if (! empty($pid) && empty($model->pid)) {
            AuthItemChild::findOne([
                'parent' => $pid,
                'child' => $model->id
            ])->delete();
        } else if ($pid !== $model->pid) {
            if ($relation = AuthItemChild::findOne([
                'parent' => $pid,
                'child' => $model->id
            ])) {
                $this->updateRelation($model, $relation);
            } else {
                $this->createRelation($model);
            }
        }
    }

    public function updateRelation($model, $relation)
    {
        $relation->parent = $model->pid;
        $relation->sort = $model->sort;
        $relation->save(false);
    }

    public function createRelation($model)
    {
        $relation = new AuthItemChild();
        $relation->parent = $model->pid;
        $relation->child = $model->id;
        $relation->sort = $model->sort;
        $relation->save(false);
    }
}
