<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统事件';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'event-index']); ?>
<?php

PanelGridView::begin(
    [
        'intro' => '系统事件信息管理',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model['name'], [
                        'view',
                        'id' => $model['id']
                    ], [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                }
            ],
            'event',
            'level',
            'is_backend:boolean',
            [
                'label' => '处理器',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-cog"></i> 设置', [
                        '/backend/event-handler/index',
                        'EventHandlerSearch[event_id]' => $model->id
                    ], [
                        'class' => 'btn btn-xs btn-default',
                        'data-pjax' => '0'
                    ]);
                }
            ],
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
    ]
);
?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-link', 'data-toggle' => 'modal', 'data-target' => '#modal-dailog']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

