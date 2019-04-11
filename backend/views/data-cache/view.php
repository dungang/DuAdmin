<?php

use yii\widgets\DetailView;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\DataCache */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '数据缓存', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->name,
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'name',
            'cache_key',
            'cache_handler',
            'expired',
            'intro',
            ],
        ])
]);
?>
