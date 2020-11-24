<?php

use yii\widgets\DetailView;
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\Cron */

$this->title = $model->task;
$this->params['breadcrumbs'][] = ['label' => '定时任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->task;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->task,
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'task',
            'mhdmd',
            'job_script',
            'param',
            'intro',
            'secrity_key',
            'is_ok:boolean',
            'is_active:boolean',
            'run_at:datetime',
            'created_at:datetime',
            'updated_at:datetime',
            ],
        ])
]);
?>
