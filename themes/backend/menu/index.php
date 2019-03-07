<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航菜单';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?php

    PanelGridView::begin([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model['id'], [
                        'view',
                        'id' => $model['id']
                    ], [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-dailog'
                    ]);
                }
            ],
            'name',
            'url:url',
            'is_front:boolean',
            'pid',
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
    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
    </p>
    <?php PanelGridView::end()?>
