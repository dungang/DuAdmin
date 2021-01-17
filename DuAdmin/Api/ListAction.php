<?php

namespace DuAdmin\Api;

class ListAction extends BaseAction
{

    public $pagination = true;

    /**
     * 关系对象查询
     * https://www.yiichina.com/doc/guide/2.0/db-active-record#lazy-eager-loading
     * 延迟加载和即时加载
     * 在 访问关联数据 中，我们解释说可以像问正常的对象属性那样 
     * 访问 Active Record 实例的关联属性。
     * SQL 语句仅在 你第一次访问关联属性时执行。
     * 我们称这种关联数据访问方法为 延迟加载
     * @var array
     */
    public $withModels = [];

    /**
     * 如果模型有标记删除的属性，
     * 默认只显示没有删除的数据
     */
    public $queryOnlyUndelete = true;

    public function run()
    {
        list($modelClass, $condition) = $this->builderFindModelCondition();
        $searchModel = new $modelClass($condition);
        if ($searchModel->hasProperty("isDel") && $this->queryOnlyUndelete) {
            $searchModel->isDel = 0;
        }
        // 动态绑定行为
        $searchModel->attachBehaviors($this->modelBehaviors);
        $dataProvider = $searchModel->search($this->composeGetParams($searchModel), '');
        foreach ($this->withModels as $modelName) {
            $dataProvider->query->with($modelName);
        }
        if (!$this->pagination) {
            $dataProvider->pagination = false;
            return $dataProvider->getModels();
        }
        return [
            'items' => $dataProvider->getModels(),
            'totalCount' => $dataProvider->pagination->totalCount,
            'pageCount' => $dataProvider->pagination->getPageCount(),
            'currentPage' => $dataProvider->pagination->getPage() + 1,
            'perPage' => $dataProvider->pagination->getPageSize(),
        ];
    }
}
