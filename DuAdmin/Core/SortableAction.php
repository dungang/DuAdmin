<?php

namespace DuAdmin\Core;

use yii\base\Action;

/**
 * 排序action
 * 
 * 模型至少需要满足至少有两个字段 id,pid 
 * 如果有depth，也会自动更新
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-19
 */
class SortableAction extends Action
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

  public $modelClass = null;

  public function run()
  {

    $sorts = \Yii::$app->request->post('sorts');
    if ($sorts) {
      if ($this->viaModelClass) {
        $this->updateViaChildren($sorts, 0);
      } else {
        $this->updateChildren($sorts, 0);
      }
      return $sorts;
    }
  }

  /**
   * 更新中间表的记录
   *
   * @param array $item
   * @param number $sort
   * @param number|string $parentId
   * @param number $depth
   * @return void
   */
  private function updateViaItem($item, $sort, $parentId, $depth = 1)
  {

    $viaModel = null;
    // 如果原本是root，则肯定没有关联关系存在
    if ($item['pid'] !== 0) {
      $activeQuery = call_user_func([
        $this->viaModelClass,
        'find'
      ]);
      $viaModel = $activeQuery->where([
        $this->viaChild => $item['id'],
        $this->viaParent => $item['pid']
      ])->limit(1)->one();
    }
    if ($viaModel) {
      // 如果有关联关系，更新后的pid===0，则表示变为root节点，则不需要关联关系了
      if ($parentId === 0) {
        $viaModel->delete();
        // 只用更新本身的排序即可
        $this->viaUpdatetItemSort($item, $sort, $depth);
      } else {
        // 如果有，则只需要更新parent即可
        $viaModel[$this->viaParent] = $parentId;
        //如果有深度字段，更新深度
        if ($viaModel->hasProperty('depth')) {
          $viaModel->depth = $depth;
        }
        $viaModel->sort = $sort;
        $viaModel->save(false);
      }
    } else {
      // 没有关联关系
      // 如果更新后的pid === 0，则表示只用更新排序即可
      if ($parentId === 0) {
        $this->viaUpdatetItemSort($item, $sort, $depth);
      } else {
        // 否则，创建关联关系
        $viaModel = \Yii::createObject($this->viaModelClass);
        $viaModel[$this->viaParent] = $parentId;
        $viaModel[$this->viaChild] = $item['id'];
        //如果有深度字段，更新深度
        if ($viaModel->hasProperty('depth')) {
          $viaModel->depth = $depth;
        }
        $viaModel->sort = $sort;
        $viaModel->save(false);
      }
    }
    if (isset($item['children']) && is_array($item['children'])) {
      //如果有子集合，深度加1
      $this->updateViaChildren($item['children'], $item['id'], $depth + 1);
    }
  }

  /**
   * 更节点本身的排序
   *
   * @param array $item
   * @param integer $sort
   * @param number $depth
   */
  private function viaUpdatetItemSort($item, $sort, $depth = 1)
  {

    $model = $this->findModel([
      'id' => $item['id']
    ]);
    if ($model) {
      $model->sort = $sort;
      //如果有深度字段，更新深度
      if ($model->hasProperty('depth')) {
        $model->depth = $depth;
      }
      $model->save(false);
    }
  }

  /**
   * 批量更新中间记录
   *
   * @param array $children
   * @param number|string $parentId
   * @param number $depth
   * @return void
   */
  private function updateViaChildren($children, $parentId, $depth = 1)
  {

    foreach ($children as $sort => $item) {
      $this->updateViaItem($item, $sort, $parentId, $depth);
    }
  }

  /**
   * 批量更新子记录
   *
   * @param array $children
   * @param number|string $parentId
   * @param number $depth
   * @return void
   */
  private function updateChildren($children, $parentId, $depth = 1)
  {

    foreach ($children as $sort => $item) {
      $this->updateItem($item, $sort, $parentId, $depth);
    }
  }

  /**
   *
   * 更新表的记录
   *
   * @param array $item
   * @param number $sort
   * @param number|string $parentId
   * @param number $depth
   * @return void
   */
  private function updateItem($item, $sort, $parentId, $depth = 1)
  {

    $model = $this->findModel([
      'id' => $item['id']
    ]);
    if ($model) {
      // 1层深度的时候可能没有pid
      if ($model->hasProperty('pid')) {
        $model->pid = $parentId;
      }
      //如果有深度字段，更新深度
      if ($model->hasProperty('depth')) {
        $model->depth = $depth;
      }
      $model->sort = $sort;
      $model->save(false);
    }
    if (isset($item['children']) && is_array($item['children'])) {
      //如果有子集合，深度加1
      $this->updateChildren($item['children'], $item['id'], $depth + 1);
    }
  }

  private function findModel($id)
  {

    return call_user_func([
      $this->modelClass,
      'findOne'
    ], $id);
  }
}
