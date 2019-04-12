<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\models\Event;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\EventHandlerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$event = Event::findOne([
    'id' => $searchModel->event_id
]);
$this->title = $event->name . '系统事件处理器';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'event-handler-index']); ?>
<?php

PanelGridView::begin(
    [
        'intro' => '系统事件处理器信息管理',
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
            'intro',
            'is_active:boolean',
            'handler',
            'sort',
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
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create','EventHandler[event_id]'=>$searchModel->event_id], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>

