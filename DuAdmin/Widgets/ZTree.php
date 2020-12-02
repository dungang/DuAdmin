<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Json;
use DuAdmin\Assets\ZTreeAsset;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class ZTree extends Widget
{
    /**
     * 默认不展开节点
     *
     * @var boolean
     */
    public $expandAll = false;

    /**
     * 节点的url
     *
     * @var string|array|null
     */
    public $url = null;

    /**
     * url参数的名称
     *
     * @var string
     */
    public $urlParamName = 'id';

    /**
     * url参数的值是否使用子节点的集合
     *
     * @var boolean
     */
    public $urlParamValueUseChild = false;

    /**
     * ZTree的setting
     *
     * @var array
     */
    public $settings;

    /**
     * 节点
     *
     * @var array
     */
    public $nodes = [];

    public function run()
    {
        ZTreeAsset::register($this->view);
        $id = $this->getId();
        $settings = Json::encode($this->settings ?: new \stdClass());
        if ($this->url || $this->expandAll) {
            $this->refactor($this->nodes, $this->url, $this->expandAll);
        }
        $nodes = Json::encode($this->nodes);
        $this->view->registerJs("$.fn.zTree.init($('#{$id}'),$settings,$nodes);");
    }

    protected function refactor(&$nodes, $url = null, $open = false)
    {
        foreach ($nodes as &$child) {
            $hasChild = isset($child['children']) && !empty($child['children']);
            if ($url && empty($child['url'])) {
                $ids = $this->getChildIds($child, $hasChild);
                if (is_array($url)) {
                    if (is_array($ids)) {
                        foreach ($ids as $id) {
                            $url[$this->urlParamName][] = $id;
                        }
                    } else if ($child['id']) {
                        $url[$this->urlParamName] = $child['id'];
                    }
                    $child['url'] = Url::to($url);
                } else {
                    if (is_array($ids)) {
                        foreach ($ids as $id) {
                            $url .= '&' . $this->urlParamName . '[]=' . $id;
                        }
                    } else if ($child['id']) {
                        $url .= '&' . $this->urlParamName . '=' . $child['id'];
                    }
                }
            }
            $child['open'] = $open;
            if ($hasChild) {
                $this->refactor($child['children'], $url, $open);
            }
        }
    }

    /**
     * 获取子节点的Id
     *
     * @param array $node
     * @param array $hasChild
     * @return int|string|array
     */
    protected function getChildIds($node, $hasChild)
    {
        if ($hasChild && $this->urlParamValueUseChild) {
            return ArrayHelper::getColumn($node['children'], 'id');
        }
        return $node['id'];
    }
}
