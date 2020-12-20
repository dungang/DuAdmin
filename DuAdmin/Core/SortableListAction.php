<?php
namespace DuAdmin\Core;

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
        $model->load(\Yii::$app->request->get());
        list ($modelClass, $condition) = $this->builderFindModelCondition($model->attributes);
        $activeQuery = $modelClass::find();
        if ($this->viaModelClass) {
            $t1 = call_user_func([
                $modelClass,
                'tableName'
            ]);
            $t2 = call_user_func([
                $this->viaModelClass,
                'tableName'
            ]);
            $activeQuery->select([
                $t1 . '.*',
                $t2 . '.' . $this->viaParent . ' as pid'
            ])->leftJoin($t2, $t2 . '.' . $this->viaChild . ' = ' . $t1 . '.id');
            $t1Filters = array_map(function ($filter) use ($t1) {
                return $t1 . '.' . $filter;
            }, array_keys($condition));
            $condition = array_combine($t1Filters, $condition);
        }
        $models = $activeQuery->where($condition)
            ->asArray()
            ->orderBy('sort')
            //->indexBy('id') AppHelper::listToTree() 会处理
            ->all();
        return $this->controller->render($this->id, [
            'models' => $models,
            'model' => $model
        ]);
    }
}

;