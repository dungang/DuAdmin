<?php

namespace app\mmadmin\widgets;

use yii\base\Widget;
use app\mmadmin\helpers\MAHelper;
use Yii;
use yii\helpers\Html;

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

    public function run()
    {

        $this->normalizeItems();
        //权限过滤
        $this->items = array_filter($this->items, function ($item) {
            if (Yii::$app->user->id === 1) return true;
            if (isset($item['r']) && $item['r'] != '/default/index') {
                return Yii::$app->user->can($item['r']);
            } else {
                return true;
            }
        });
        $this->items = MAHelper::listToTree($this->items, $this->idKey, $this->pidKey);
        $html = $this->enableHeader ? Html::tag('li', $this->headerLabel, [
            'class' => 'header'
        ]) : '';
        //url 为空 或者 是 '#' 的菜单没有子菜单 不显示
        foreach ($this->items as $item) {
            if (isset($item['items']) && is_array($item['items'])) {
                $html .= $this->renderTreeItem($item);
            } else if(!(empty($item['url']) || $item['url']=='#')) {
                $html .= $this->renderItem($item);
            }
        }
        return Html::tag('div', $html, [
            'class' => 'sidebar-menu',
            'data-widget' => 'tree'
        ]);
    }

    protected function normalizeItems()
    {
        $host = \Yii::$app->request->getHostName();
        $path = \Yii::$app->request->getPathInfo();
        $moduleId = (\Yii::$app->controller->module->id == \Yii::$app->id) ? '' : \Yii::$app->controller->module->id;
        $routePrefix = $moduleId ? $moduleId . '/' . \Yii::$app->controller->id : \Yii::$app->controller->id;

        $params = [];
        parse_str(str_replace([
            '[',
            ']'
        ], '___', \Yii::$app->request->queryString), $params);
        $counters = [];

        // 算分
        foreach ($this->items as $i => &$item) {
            $item[$this->activeKey] = false;
            $item['target'] = '_self';
            if ($url = $item[$this->urlKey]) {
                $urlInfo = parse_url($url);
                if (empty($urlInfo['host']) || $host == $urlInfo['host']) {
                    $counters[$i] = 1;
                    if (empty($urlInfo['path']) || $path == $urlInfo['path']) {
                        $counters[$i] += 1;
                        if (isset($urlInfo['query'])) {
                            $checkParams = [];
                            \parse_str(\str_replace([
                                '[',
                                ']'
                            ], '___', $urlInfo['query']), $checkParams);
                            //检查路由前缀加分
                            if (isset($checkParams['r'])) {
                                $route = \ltrim($checkParams['r'], '/');
                                $item['r'] = '/' . $route;
                                $counters[$i] += \stripos($route, $routePrefix) === 0 ? 1 : 0;
                            }
                            $counters[$i] += count(array_intersect_assoc($checkParams, $params));
                        }
                    }
                } else {
                    $item['target'] = '_blank';
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
        $activeItem = $this->items[$idx];
        $this->items[$idx][$this->activeKey] = true;

        // 找最高分的一层上节点
        foreach ($this->items as &$item) {
            if ($item[$this->idKey] == $activeItem['pid']) {
                $item[$this->activeKey] = true;
            }
        }
    }

    protected function renderLink($item)
    {
        $icon = empty($item['icon']) ? '' : '<i class="' . $item['icon'] . '"></i> ';
        return Html::a($icon . '<span>' . $item[$this->nameKey] . '</span>', $item[$this->urlKey], ['target' => $item['target']]);
    }

    protected function renderItem($item)
    {
        $active = $item[$this->activeKey] ? [
            'class' => 'active'
        ] : [];
        return Html::tag('li', $this->renderLink($item), $active);
    }

    protected function renderTreeItem($item)
    {

        $active = $item[$this->activeKey] ? 'active' : '';
        $html = '';
        foreach ($item['items'] as $child) {
            $html .= $this->renderItem($child);
        }
        $content = $this->renderLink($item) . Html::tag('ul', $html, [
            'class' => 'treeview-menu'
        ]);
        return Html::tag('li', $content, [
            'class' => 'treeview ' . $active
        ]);
    }
}
