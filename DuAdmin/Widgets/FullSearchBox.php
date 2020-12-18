<?php
namespace DuAdmin\Widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * 列表页面默认的搜索框
 *
 * @author dungang<dungang@126.com>
 * @since 2020年12月1日
 */
class FullSearchBox extends InputWidget
{

    /**
     * 请求地址
     *
     * @var array
     */
    public $action;

    public function init()
    {
        $this->name = 'full_search';
        parent::init();
        echo '<div class="full-search-box">';
        echo Html::beginForm(Url::to($this->action), 'GET', $this->options);
    }

    public function run()
    {
        echo $this->renderSearchBox(\Yii::$app->request->get($this->name,''));
        echo Html::endForm();
        echo "</div>";
    }

    protected function renderSearchBox($value)
    {
        return <<<BOX
    <div class="input-group">
      <input type="text" name="full_search" class="form-control" value="{$value}" placeholder="关键词搜索.">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" ><i class="fa fa-search"></i> 搜索</button>
      </span>
    </div>
BOX;
    }
}

