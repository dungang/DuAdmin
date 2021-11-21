<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\DashboardWidget */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_dashboard_widget', 'Dashboard Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->name),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'name',
            'widget',
            'args',
            'argsInfo',
            'status',
            'sort',
            'type',
            ],
        ])
]);
?>
