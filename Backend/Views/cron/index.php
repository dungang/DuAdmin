<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
use DuAdmin\Helpers\CrontabHelper;
use DuAdmin\Helpers\AppHelper;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\CronSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '定时任务';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'cron-index']); ?>
<div class="well bg-white no-border">
    <?php list($cronStatus, $cronTracedAt, $isRunning) = CrontabHelper::prepareCronSetting(); ?>
    <p>
        <strong>服务状态: </strong>
        <?php

        echo intval($cronStatus) > 0 ? '<span class="btn btn-xs btn-success">已开启 </span> ' . Html::a('<i class="fa  fa-stop"></i> 停止', [
            'switch-service'
        ], [
            'class' => 'btn btn-default btn-xs',
            'id' => 'switch-service',
            'data-pjax' => '0'
        ]) : '<span class="btn btn-xs btn-warning">已关闭 </span> ' . Html::a('<i class="fa fa-play-circle"></i> 启动', [
            'switch-service'
        ], [
            'class' => 'btn btn-default btn-xs',
            'id' => 'switch-service',
            'data-pjax' => '0'
        ]) ?>
    </p>
    <p>服务运行状态：<?= $isRunning ? '运行中...' : '未运行' ?></p>
    <p>服务启动时间：<?= \Yii::$app->formatter->asDatetime($cronStatus) ?></p>
    <p>最后执行时间：<?= \Yii::$app->formatter->asDatetime($cronTracedAt) ?></p>
</div>
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
                        'title' => $model['errorMsg'],
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dialog'
                    ]);
                }
            ],
            'mhdmd',
            'isOk:boolean',
            'isActive:boolean',
            'runAt',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'template' => '{once} {view} {update} {delete}',
                'buttons' => [
                    'once' => function ($url, $model, $key) {
                        return AppHelper::linkButton('<i class="fa fa-time"></i> ' . Yii::t('app_cron', 'Action Once'), $url, [
                            'data-confirm' => Yii::t('app_cron', 'Are you sure you want to proccess this item once?'),
                            'data-method' => 'post'
                        ]);
                    }
                ]
            ]
        ]
    ]
);
?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>

<?= DuAdmin\Widgets\FullSearchBox::widget(['action' => ['index']]) ?>

<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>