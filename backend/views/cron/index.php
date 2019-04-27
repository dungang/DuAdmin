<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\helpers\CrontabHelpers;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\CronSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '定时任务';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'cron-index']); ?>
<?php

PanelGridView::begin(
    [
        'intro' => '定时任务信息管理',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'task',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model['task'], [
                        'view',
                        'id' => $model['id']
                    ], [
                        'title' => $model['error_msg'],
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                }
            ],
            'mhdmd',
            'job_script',
            'is_ok:boolean',
            'is_active:boolean',
            'run_at:datetime',
            [
                'class' => '\app\kit\grids\ActionColumn',
                'buttonsOptions' => [
                    'update' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ],
                    'view' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]
                ]
            ]
        ]
    ]);
?>
<div class="well">
    <?php list ($cron_status, $cron_traced_at) = CrontabHelpers::prepareCronSetting();?>
    <p>
		<strong>服务运行状态: </strong>
    <?php

    echo intval($cron_status) > 0 ? '<span class="btn btn-xs btn-success">运行中 ... </span> ' . Html::a('<i class="fa  fa-stop"></i> 停止', [
        'switch-service'
    ], [
        'class' => 'btn btn-default btn-xs',
        'id' => 'switch-service',
        'data-pjax' => '0'
    ]) : '<span class="btn btn-xs btn-warning">已停止 </span> ' . Html::a('<i class="fa fa-play-circle"></i> 启动', [
        'switch-service'
    ], [
        'class' => 'btn btn-default btn-xs',
        'id' => 'switch-service',
        'data-pjax' => '0'
    ])?></p>
	<p>服务启动时间：<?= \Yii::$app->formatter->asDatetime($cron_status)?></p>
	<p>最后执行时间：<?= \Yii::$app->formatter->asDatetime($cron_traced_at)?></p>
</div>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

