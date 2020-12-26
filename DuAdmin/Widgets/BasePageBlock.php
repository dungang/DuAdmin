<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\db\Query;
use DuAdmin\Models\PageBlockData;

abstract class BasePageBlock extends Widget
{

    /**
     * page block model
     *
     * @var PageBlockData
     */
    public $model;

    /**
     *
     * @var Query
     */
    public $query;

    public final function run()
    {
        if ($this->model->style) {
            $this->options['style'] = $this->model->style;
        }
        $this->initQuery();
        if ($this->query) {
            $this->composerQuery();
        }
        if ($this->enableCache()) {
            $key = get_called_class();
            return \Yii::$app->cache->getOrSet($key, function () {
                return $this->showBlock();
            }, strtotime($this->model->expiredAt));
        }
        return $this->showBlock();
    }

    private function showBlock()
    {
        $content = $this->renderPageBlock();
        if ($content) {
            return Html::tag('div', $content, $this->options);
        }
        return '<!-- ' . $this->model->showTitle . ' : ' . get_called_class() . ' NO DATA -->';
    }

    public function composerQuery()
    {
        if ($this->model->filter) {
            $filter = [];
            parse_str($this->model->filter, $filter);
            if ($filter) {
                $this->query->where($filter);
            }
        }
        if ($this->model->orderBy) {
            $this->query->orderBy($this->model->orderBy);
        }
        if ($this->model->size) {
            $this->query->limit($this->model->size);
        }
    }

    public function enableCache()
    {
        if ($this->model->enableCache) {
            if (\Yii::$app->get('cache', false)) {
                return true;
            }
        }
        return false;
    }

    abstract function renderPageBlock();

    abstract function initQuery();

    public static function factory()
    {
        $blockDatas = PageBlockData::find()->with('block')
            ->orderBy('sort asc')
            ->all();

        foreach ($blockDatas as $data) {
            if ($data->block) {
                $widgetClass = $data->block->widget;
                if (class_exists($widgetClass)) {
                    echo call_user_func([
                        $widgetClass,
                        'widget'
                    ], [
                        'model' => $data
                    ]);
                }
            }
        }
    }
}

