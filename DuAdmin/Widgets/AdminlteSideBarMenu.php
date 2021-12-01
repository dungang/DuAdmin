<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * 指支持2层菜单
 *
 * @author dungang
 *
 */
class AdminlteSideBarMenu extends Widget
{

    public $headerLabel = 'Header';

    public $enableHeader = true;

    public $idKey = 'id';

    public $pidKey = 'pid';

    public $urlKey = 'url';

    public $nameKey = 'label';

    public $activeKey = '__is_active';

    public $items;

    /**
     * 扩展参数，添加到路由的参数
     */
    public $extendParams = [];

    public function run()
    {
        $this->normalizeItems();

        // 权限过滤
        /* @var Authable $user */
        $user = Yii::$app->user->identity;
        if (!$user->isSuperAdmin()) {
            $this->items = array_filter($this->items, function ($item) use ($user) {
                //echo var_dump( $item);die;
                if ($item['requireAuth']) {
                    if (isset($item['route']) && $item['route'] != 'default/index') {
                        return Yii::$app->authManager->checkAccessWithoutRule($user->id, trim($item['route'], '/'));
                    }
                }
                return true;
            });
        }
        $this->items = AppHelper::listToTree($this->items, $this->idKey, $this->pidKey);


        return $this->renderItems($this->items);
    }

    public function renderItems($items, $isFirst = true)
    {
        // url 为空 或者 是 '#' 的菜单没有子菜单 不显示
        if ($isFirst) {
            $html = '<ul class="sidebar-menu" data-widget="tree">';
            if ($this->enableHeader) {
                $html = $html .  Html::tag('li', $this->headerLabel, [
                    'class' => 'header'
                ]);
            }
        } else {
            $html = '<ul class="treeview-menu">';
        }
        foreach ($items as $item) {
            if (empty($item['url']) || $item['url'] == '#') {
                if (empty($item['children'])) {
                    continue;
                }
            }
            $active = $item[$this->activeKey] ? 'active' : '';
            if (isset($item['children']) && is_array($item['children'])) {
                $marker = '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
                $html = $html . '<li class="treeview ' . $active . '">' . $this->renderLink($item, $marker) . $this->renderItems($item['children'], false) . '</li>';
            } else {
                $html = $html . '<li class="'  . $active . '">'  . $this->renderLink($item) . '</li>';
            }
        }
        return $html . '</ul>';
    }

    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function normalizeItems()
    {
        if (empty($this->items)) {
            return;
        }
        $controllerUnionId = \Yii::$app->controller->uniqueId;
        $controllerRouteParts = explode('/', trim($controllerUnionId, '/'));
        $params = [];
        parse_str(\Yii::$app->request->queryString, $params);
        $counters = [];

        // 算分
        foreach ($this->items as $i => &$item) {
            $item[$this->activeKey] = false;
            $item['target'] = '_self';
            if ($item['isOuter']) {
                $item['target'] = '_blank';
                continue;
            } else {
                if ($url = $item[$this->urlKey]) {
                    $urlInfo = parse_url($url);
                    if (isset($urlInfo['path'])) {
                        // 路径就是route
                        $route = $urlInfo['path'];
                        $routeParts = explode('/', trim($route, '/'));
                        $counters[$i] = 1;
                        // 检查路由前缀加分
                        //$counters[ $i ] += \stripos( $route, $controllerUnionId ) == 0 ? 1 : 0;
                        $counters[$i] += count(array_intersect_assoc($routeParts, $controllerRouteParts));
                        $queryParams = [
                            $urlInfo['path']
                        ];
                        if (isset($urlInfo['query'])) {

                            \parse_str($urlInfo['query'], $queryParams);

                            $counters[$i] += count(array_intersect_assoc($queryParams, $params));
                            $queryKeys = array_keys($queryParams);
                            $queryParams = array_combine($queryKeys, array_values($queryParams));
                            array_unshift($queryParams, $urlInfo['path']);
                        }
                        $queryParams[0] = '/' . $queryParams[0];
                        $item[$this->urlKey] = ArrayHelper::merge($queryParams, $this->extendParams);

                        $item['route'] = $route;
                        unset($queryParams[0]);
                        $item['params'] = $queryParams;
                    } else {
                        continue;
                    }
                }
            }
        }

        // 找最高分
        $max = 0;
        $idx = 0;
        foreach ($counters as $i => $count) {
            if ($count > $max) {
                $max = $count;
                $idx = $i;
            }
        }
        $this->activeTreeBack($idx);
    }

    public function activeTreeBack($idx)
    {
        $this->items[$idx][$this->activeKey] = true;
        $pid = $this->items[$idx]['pid'];
        if ($pid != 0 && isset($this->items[$pid])) {
            $this->activeTreeBack($pid);
        }
    }

    protected function renderLink($item, $marker = '')
    {
        $icon = empty($item['icon']) ? '' : '<i class="' . $item['icon'] . '"></i> ';
        return Html::a($icon . '<span>' . $item[$this->nameKey] . '</span>' . $marker, $item[$this->urlKey], [
            'target' => $item['target']
        ]);
    }
}
