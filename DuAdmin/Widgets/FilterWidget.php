<?php

namespace DuAdmin\Widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class FilterWidget extends Widget
{

    public $name = '分类：';

    public $modelClass;

    public $filters;

    public $filterAttr = 'id';

    public $filterParamName = 'categoryId';

    public $txtAttr = 'name';

    public $condition = [];

    public $hots = [];

    public $orderBy = 'sort asc';

    public $cssClass = 'filter-bar';

    public function run()
    {
        $route = Yii::$app->request->queryParams;
        array_unshift($route, '/' . Yii::$app->controller->route);
        $value = Yii::$app->request->get($this->filterParamName);
        if (!$this->filters) {
            $query = call_user_func([$this->modelClass, 'find']);
            $this->filters = $query->select([$this->filterAttr, $this->txtAttr])
                ->where($this->condition)->asArray()
                ->orderBy($this->orderBy)->all();
        }
        array_unshift($this->filters, [$this->filterAttr => null, $this->txtAttr => '全部']);
        $liElements = array_map(function ($filter) use ($route, $value) {
            $route[$this->filterParamName] = $filter[$this->filterAttr];
            $className = null;
            if ($route[$this->filterParamName] === $value) {
                $className = 'active';
            }
            return Html::tag('li', Html::a($filter[$this->txtAttr], $route), ['class' => $className]);
        }, $this->filters);

        return Html::tag('div', '<div class="filter-label">' . $this->name . '</div>' . Html::tag(
            'ul',
            implode('', $liElements),
            ['class' => 'filter']
        ), ['class' => $this->cssClass]);
    }
}
