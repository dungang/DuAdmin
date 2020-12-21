<?php
namespace DuAdmin\Core;

use DuAdmin\Mysql\ActiveQuery;
use DuAdmin\Mysql\Query;

/**
 * 排序列表action
 * 当使用中间表的时候，必须保证
 *
 * child 和 parent 必须是相同类型的节点
 * 只要满足查询调节一致即可
 *
 * 参考rbac的表即可
 *
 * @author dunga
 *        
 */
class SortableListAction extends BaseAction
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
        $model = \Yii::createObject($this->modelClass);

        $filter = array_filter($model->attributes, function ($attr) {
            return $attr !== null;
        });
        list ($modelClass, $condition) = $this->builderFindModelCondition($filter);

        $model->load($condition);
        /* @var $activeQuery ActiveQuery */
        $activeQuery = $modelClass::find();
        
        //使用中间表建立父子关系
        if ($this->viaModelClass) {
            $t1 = call_user_func([
                $modelClass,
                'tableName'
            ]);
            $t2 = call_user_func([
                $this->viaModelClass,
                'tableName'
            ]);
            // child 和 parent 必须是相同类型的节点 $condition
            $subQuery = (new Query())->select('id')
                ->from($t1)
                ->where($condition);
            $activeQuery->select([
                $t1 . '.*',
                $t2 . '.' . $this->viaParent . ' as pid'
            ])->leftJoin($t2, [
                'and',
                $t2 . '.' . $this->viaChild . ' = ' . $t1 . '.id',
                [
                    $t2 . '.' . $this->viaParent => $subQuery
                ]
            ]);
            $t1Filters = array_map(function ($filter) use ($t1) {
                return $t1 . '.' . $filter;
            }, array_keys($condition));
            $condition = array_combine($t1Filters, $condition);
        }
        // child 和 parent 必须是相同类型的节点 $condition
        $models = $activeQuery->where($condition)
            ->asArray()
            ->orderBy('sort')
            ->
        // ->indexBy('id') AppHelper::listToTree() 会处理
        all();
        $this->data = [
            'models' => $models,
            'model' => $model
        ];
        $this->beforeRender();
        return $this->controller->render($this->id, $this->data);
    }
}

;