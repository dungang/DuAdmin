<?php
namespace DuAdmin\Core;

/**
 * 排序action
 * @author dungang<dungang@126.com>
 * @since 2020-12-19
 */
class SortableAction extends BaseAction
{

    /**
     * 中间表的模型类
     * 字符串
     *
     * @var string
     */
    public $viaModelClass = null;
    
    public $viaParent = 'parent';
    
    public $viaChild = 'child';

    public function run()
    {
        $sorts = \Yii::$app->request->post('sorts');
        if ($sorts) {
            if($this->viaModelClass) {
                $this->updateViaChildren($sorts, 0);
            } else {
                $this->updateChildren($sorts, 0);
            }
            return $sorts;
        }
    }

    /**
     * 更新中间表的记录
     * @param array $item
     * @param number $sort
     * @param number|string $parentId
     * @return void
     */
    private function updateViaItem($item, $sort, $parentId)
    {
        $activeQuery = call_user_func([
            $this->viaModelClass,
            'find'
        ]);
        $viaModel = $activeQuery->where([
            $this->viaChild => $item['id'],
            $this->viaParent => $parentId
        ])
            ->limit(1)
            ->one();
        if ($viaModel) {
            $viaModel->sort = $sort;
            $viaModel->save(false);
        } else {
            $model = $this->findModel(false, [
                'id' => $item['id']
            ]);
            if ($model) {
                $model->sort = $sort;
                $model->save(false);
            }
        }
        if (isset($item['children']) && is_array($item['children'])) {
            $this->updateViaChildren($item['children'], item['id']);
        }
    }
    
    /**
     * 批量更新中间记录
     * @param array $children
     * @param number|string $parentId
     * @return void
     */
    private function updateViaChildren($children, $parentId)
    {
        foreach ($children as $sort => $item) {
            $this->updateViaItem($item, $sort, $parentId);
        }
    }

    /**
     * 批量更新子记录
     * @param array $children
     * @param number|string $parentId
     * @return void
     */
    private function updateChildren($children, $parentId)
    {
        foreach ($children as $sort => $item) {
            $this->updateItem($item, $sort, $parentId);
        }
    }

    /**
     * 
     * 更新表的记录
     * @param array $item
     * @param number $sort
     * @param number|string $parentId
     * @return void
     */
    private function updateItem($item, $sort, $parentId)
    {
        $model = $this->findModel(false, [
            'id' => $item['id']
        ]);
        if ($model) {
            $model->pid = $parentId;
            $model->sort = $sort;
            $model->save(false);
        }
        if (isset($item['children']) && is_array($item['children'])) {
            $this->updateChildren($item['children'], item['id']);
        }
    }
}

